<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CheckoutRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Controller
{
    use AuthorizesRequests;

    private const CART_KEY = 'shopping_cart';

    private const CART_SERVICES_KEY = 'shopping_cart_services';

    public function index(): View
    {
        $authenticatedUserId = (int) Auth::id();

        $viewData = [];
        $viewData['title'] = __('order.my_orders_title');
        $viewData['orders'] = Order::with('items.plant', 'items.service')
            ->where('user_id', $authenticatedUserId)
            ->orderByDesc('id')
            ->get();

        return view('orders.index')->with('viewData', $viewData);
    }

    public function show(string $id): View
    {
        $order = Order::findOrFail($id);
        $this->authorize('view', $order);
        $order->loadMissing('items.plant', 'items.service');

        $viewData = [];
        $viewData['title'] = __('order.detail_title');
        $viewData['order'] = $order;

        return view('orders.show')->with('viewData', $viewData);
    }

    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        $cartServices = $request->session()->get(self::CART_SERVICES_KEY, []);

        if (count($cart) === 0 && count($cartServices) === 0) {
            return redirect()->route('cart.index')
                ->with('error', __('cart.empty'));
        }

        $cartItems = collect();

        if (! empty($cart)) {
            $plants = Plant::with('category')
                ->whereIn('id', array_keys($cart))
                ->where('active', true)
                ->get()
                ->keyBy(fn (Plant $p) => $p->getId());

            foreach ($cart as $plantId => $qty) {
                if (! isset($plants[$plantId])) {
                    continue;
                }
                $plant = $plants[$plantId];
                $item = new Item;
                $item->setPlantId($plant->getId());
                $item->setServiceId(null);
                $item->setQuantity((int) $qty);
                $item->setUnitPrice($plant->getPrice());
                $item->setRelation('plant', $plant);
                $item->setRelation('service', null);
                $cartItems->push($item);
            }
        }

        if (! empty($cartServices)) {
            $services = Service::whereIn('id', array_keys($cartServices))
                ->where('active', true)
                ->get()
                ->keyBy(fn (Service $s) => $s->getId());

            foreach ($cartServices as $serviceId => $qty) {
                if (! isset($services[$serviceId])) {
                    continue;
                }
                $service = $services[$serviceId];
                $item = new Item;
                $item->setPlantId(null);
                $item->setServiceId($service->getId());
                $item->setQuantity(1);
                $item->setUnitPrice($service->getPrice());
                $item->setRelation('service', $service);
                $item->setRelation('plant', null);
                $cartItems->push($item);
            }
        }

        $viewData = [];
        $viewData['title'] = __('order.checkout_title');
        $viewData['cartItems'] = $cartItems;
        $viewData['totalQuantity'] = $cartItems->sum(fn (Item $item) => $item->getQuantity());
        $viewData['totalAmount'] = $cartItems->sum(fn (Item $item) => $item->calculateSubTotal());
        $viewData['user'] = Auth::user();

        return view('checkout.index')->with('viewData', $viewData);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        $cartServices = $request->session()->get(self::CART_SERVICES_KEY, []);

        if (count($cart) === 0 && count($cartServices) === 0) {
            return redirect()->route('cart.index')
                ->with('error', __('cart.empty'));
        }

        $paymentMethod = (string) $request->validated('payment_method');
        $authenticatedUser = Auth::user();
        $authenticatedUserId = (int) $authenticatedUser->getId();

        $order = new Order;
        $order->setUserId($authenticatedUserId);
        $order->setPaymentMethod($paymentMethod);
        $order->placeOrder();
        $order->setTotal(0);
        $order->save();

        $total = 0;

        foreach ($cart as $plantId => $quantity) {
            $plant = Plant::where('active', true)->find((int) $plantId);

            if (! $plant || (int) $quantity <= 0) {
                continue;
            }

            $item = new Item;
            $item->setOrderId($order->getId());
            $item->setPlantId($plant->getId());
            $item->setServiceId(null);
            $item->setQuantity((int) $quantity);
            $item->setUnitPrice($plant->getPrice());
            $item->save();

            $plant->setStock(max(0, $plant->getStock() - (int) $quantity));
            $plant->save();

            $total += $item->calculateSubTotal();
        }

        foreach ($cartServices as $serviceId => $quantity) {
            $service = Service::where('active', true)->find((int) $serviceId);

            if (! $service) {
                continue;
            }

            $item = new Item;
            $item->setOrderId($order->getId());
            $item->setPlantId(null);
            $item->setServiceId($service->getId());
            $item->setQuantity(1);
            $item->setUnitPrice($service->getPrice());
            $item->save();

            $total += $item->calculateSubTotal();
        }

        $order->setTotal($total);
        $order->save();

        $request->session()->forget(self::CART_KEY);
        $request->session()->forget(self::CART_SERVICES_KEY);

        return redirect()->route('order.show', $order->getId())
            ->with('success', __('order.placed_successfully'));
    }
}

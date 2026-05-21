<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\Item;
use App\Models\Plant;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CartController extends Controller
{
    private const CART_KEY = 'shopping_cart';

    private const CART_SERVICES_KEY = 'shopping_cart_services';

    public function index(Request $request): View
    {
        $cartItems = $this->buildCartItems($request);

        $viewData = [];
        $viewData['title'] = __('cart.title');
        $viewData['cartItems'] = $cartItems;
        $viewData['totalQuantity'] = $cartItems->sum(fn (Item $item) => $item->getQuantity());
        $viewData['totalAmount'] = $cartItems->sum(fn (Item $item) => $item->calculateSubTotal());

        return view('cart.index')->with('viewData', $viewData);
    }

    public function add(AddToCartRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($validated['item_type'] === 'service') {
            $serviceId = (int) $validated['service_id'];
            $cartServices = $request->session()->get(self::CART_SERVICES_KEY, []);
            $cartServices[$serviceId] = 1;
            $request->session()->put(self::CART_SERVICES_KEY, $cartServices);

            return redirect()->route('cart.index')->with('success', __('cart.service_added'));
        }

        $plantId = (int) $validated['plant_id'];
        $plant = Plant::findOrFail($plantId);

        $cart = $request->session()->get(self::CART_KEY, []);
        $current = (int) ($cart[$plantId] ?? 0);
        $newQuantity = min($plant->getStock(), $current + max(1, (int) ($validated['quantity'] ?? 1)));

        if ($newQuantity > 0) {
            $cart[$plantId] = $newQuantity;
            $request->session()->put(self::CART_KEY, $cart);
        }

        return redirect()->route('cart.index')->with('success', __('cart.plant_added'));
    }

    public function update(UpdateCartItemRequest $request, string $id): RedirectResponse
    {
        $activePlant = Plant::where('active', true)->findOrFail($id);
        $quantity = (int) $request->validated('quantity');
        $plantId = $activePlant->getId();

        $cart = $request->session()->get(self::CART_KEY, []);

        if (! array_key_exists($plantId, $cart)) {
            return redirect()->route('cart.index');
        }

        if ($quantity <= 0) {
            unset($cart[$plantId]);
        } else {
            $cart[$plantId] = min($activePlant->getStock(), $quantity);
        }

        $request->session()->put(self::CART_KEY, $cart);

        return redirect()->route('cart.index')->with('success', __('cart.updated'));
    }

    public function remove(Request $request, string $id): RedirectResponse
    {
        $cart = $request->session()->get(self::CART_KEY, []);

        if (array_key_exists($id, $cart)) {
            unset($cart[$id]);
            $request->session()->put(self::CART_KEY, $cart);
        }

        return redirect()->route('cart.index')->with('success', __('cart.plant_removed'));
    }

    public function removeService(Request $request, string $id): RedirectResponse
    {
        $cartServices = $request->session()->get(self::CART_SERVICES_KEY, []);

        if (array_key_exists($id, $cartServices)) {
            unset($cartServices[$id]);
            $request->session()->put(self::CART_SERVICES_KEY, $cartServices);
        }

        return redirect()->route('cart.index')->with('success', __('cart.service_removed'));
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget(self::CART_KEY);
        $request->session()->forget(self::CART_SERVICES_KEY);

        return redirect()->route('cart.index')->with('success', __('cart.cleared'));
    }

    private function buildCartItems(Request $request): Collection
    {
        $cart = $request->session()->get(self::CART_KEY, []);
        $cartServices = $request->session()->get(self::CART_SERVICES_KEY, []);
        $cartItems = collect();

        if (! empty($cart)) {
            $plants = Plant::with('category')
                ->whereIn('id', array_keys($cart))
                ->where('active', true)
                ->get()
                ->keyBy(fn (Plant $p) => $p->getId());

            foreach ($cart as $plantId => $qty) {
                if (! isset($plants[$plantId]) || (int) $qty <= 0) {
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

        return $cartItems;
    }
}

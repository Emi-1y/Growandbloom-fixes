<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentInterface;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    use AuthorizesRequests;

    public function show(string $id): View
    {
        $order = Order::findOrFail($id);
        $this->authorize('view', $order);

        $paymentInterface = app(PaymentInterface::class);
        $paymentData = $paymentInterface->process($order);

        $viewData = [];
        $viewData['title'] = __('payment.title');
        $viewData['order'] = $order;
        $viewData['paymentData'] = $paymentData;

        return view('payment.show')->with('viewData', $viewData);
    }

    public function confirm(string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);
        $this->authorize('view', $order);

        $order->pay();
        $order->save();

        return redirect()->route('order.show', $id)
            ->with('success', __('payment.payment_confirmed'));
    }
}

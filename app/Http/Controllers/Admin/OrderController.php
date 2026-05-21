<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $paymentStatus = $request->query('payment_status');

        $query = Order::with('user')->orderByDesc('id');

        if (! empty($search)) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('id', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%');
                    });
            });
        }

        if (! empty($status)) {
            $query->where('status', $status);
        }

        if (! empty($paymentStatus)) {
            $query->where('payment_status', $paymentStatus);
        }

        $viewData = [];
        $viewData['title'] = __('order.admin_list_title');
        $viewData['subtitle'] = __('order.admin_list_subtitle');
        $viewData['orders'] = $query->paginate(30)->appends($request->query());
        $viewData['search'] = $search;
        $viewData['status'] = $status;
        $viewData['paymentStatus'] = $paymentStatus;
        $viewData['statuses'] = $this->statusOptions();
        $viewData['paymentStatuses'] = $this->paymentStatusOptions();

        return view('admin.order.index')->with('viewData', $viewData);
    }

    public function edit(string $id): View
    {
        $order = Order::findOrFail($id);
        $order->load('user', 'items.plant', 'items.service');

        $viewData = [];
        $viewData['title'] = __('order.edit_title');
        $viewData['subtitle'] = __('order.edit_subtitle');
        $viewData['order'] = $order;
        $viewData['statuses'] = $this->statusOptions();
        $viewData['paymentStatuses'] = $this->paymentStatusOptions();

        return view('admin.order.edit')->with('viewData', $viewData);
    }

    public function update(UpdateOrderStatusRequest $request, string $id): RedirectResponse
    {
        $validationData = $request->validated();

        $order = Order::findOrFail($id);
        $order->fill($validationData);
        $order->save();

        return redirect()
            ->route('admin.order.index')
            ->with('success', __('order.updated_successfully'));
    }

    private function statusOptions(): array
    {
        return [
            Order::STATUS_PENDING => __('order.status_pending'),
            Order::STATUS_COMPLETED => __('order.status_completed'),
            Order::STATUS_CANCELLED => __('order.status_cancelled'),
        ];
    }

    private function paymentStatusOptions(): array
    {
        return [
            Order::PAYMENT_PENDING => __('order.payment_status_pending'),
            Order::PAYMENT_PAID => __('order.payment_status_paid'),
            Order::PAYMENT_FAILED => __('order.payment_status_failed'),
        ];
    }
}

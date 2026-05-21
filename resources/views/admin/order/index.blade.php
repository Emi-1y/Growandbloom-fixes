{{-- Author: Emily Cardona Castañeda  --}}

@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.order.index') }}" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
            <div>
                <label for="search" class="form-label">{{ __('order.search') }}</label>
                <input type="text" id="search" name="search" class="form-control"
                    placeholder="{{ __('order.search_placeholder') }}" value="{{ $viewData['search'] }}">
            </div>
            <div>
                <label for="status" class="form-label">{{ __('order.filter_status') }}</label>
                <select id="status" name="status" class="form-select">
                    <option value="">{{ __('order.all_statuses') }}</option>
                    @foreach($viewData['statuses'] as $statusKey => $statusLabel)
                        <option value="{{ $statusKey }}" {{ $viewData['status'] === $statusKey ? 'selected' : '' }}>
                            {{ $statusLabel }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">{{ __('order.search') }}</button>
            </div>
        </form>
    </div>
</div>

@if($viewData['orders']->isEmpty())
    <div class="alert alert-info">{{ __('order.empty_admin') }}</div>
@else
    <div class="table-responsive" style="border: 1px solid var(--c-border); border-radius: var(--radius-md); overflow: hidden;">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>{{ __('order.id') }}</th>
                    <th>{{ __('order.user') }}</th>
                    <th>{{ __('order.total') }}</th>
                    <th>{{ __('order.status') }}</th>
                    <th>{{ __('order.payment_method') }}</th>
                    <th>{{ __('order.date') }}</th>
                    <th>{{ __('order.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['orders'] as $order)
                    <tr>
                        <td class="order-id">#{{ $order->getId() }}</td>
                        <td>
                            <div style="font-size: 0.88rem; font-weight: 600;">{{ $order->getUser()?->getName() ?? '—' }}</div>
                            <div style="font-size: 0.75rem; color: var(--c-muted);">{{ $order->getUser()?->getEmail() }}</div>
                        </td>
                        <td style="font-family: var(--font-mono); font-size: 0.85rem; color: var(--c-accent-dk);">{{ $order->getFormattedTotal() }}</td>
                        <td>
                            @php $statusKey = $order->getStatus(); @endphp
                            @if($statusKey === 'pending')
                                <span class="badge bg-warning">{{ __('order.status_pending') }}</span>
                            @elseif($statusKey === 'completed')
                                <span class="badge bg-success">{{ __('order.status_completed') }}</span>
                            @elseif($statusKey === 'cancelled')
                                <span class="badge bg-danger">{{ __('order.status_cancelled') }}</span>
                            @else
                                <span class="badge bg-info">{{ $statusKey }}</span>
                            @endif
                        </td>
                        <td style="font-size: 0.85rem;">{{ $order->getPaymentMethod() }}</td>
                        <td style="font-size: 0.82rem; color: var(--c-muted);">{{ $order->getFormattedDate() }}</td>
                        <td>
                            <a href="{{ route('admin.order.edit', $order->getId()) }}" class="icon-btn">
                                {{ __('order.edit_button') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.25rem;">
        {{ $viewData['orders']->links() }}
    </div>
@endif
@endsection

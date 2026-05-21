{{-- Author: Emily Cardona Castañeda --}}
@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@push('header-actions')
    <a href="{{ route('admin.order.index') }}" class="admin-btn-secondary">
        <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('order.back_button') }}
    </a>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="admin-form-card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul style="margin: 0; padding-left: 1rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.order.update', $viewData['order']->getId()) }}">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                        <div>
                            <label class="form-label">{{ __('order.id') }}</label>
                            <input type="text" class="form-control"
                                   value="#{{ $viewData['order']->getId() }}" disabled>
                        </div>
                        <div>
                            <label class="form-label">{{ __('order.total') }}</label>
                            <input type="text" class="form-control"
                                   value="{{ $viewData['order']->getFormattedTotal() }}" disabled>
                        </div>
                        <div>
                            <label class="form-label">{{ __('order.user') }}</label>
                            <input type="text" class="form-control"
                                   value="{{ $viewData['order']->getUser()->getName() }}" disabled>
                        </div>
                        <div>
                            <label class="form-label">{{ __('order.payment_method') }}</label>
                            <input type="text" class="form-control"
                                   value="{{ $viewData['order']->getPaymentMethod() }}" disabled>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">{{ __('order.status') }}</label>
                        <select id="status" name="status" class="form-select">
                            @foreach($viewData['statuses'] as $statusKey => $statusLabel)
                                <option value="{{ $statusKey }}"
                                    {{ old('status', $viewData['order']->getStatus()) === $statusKey ? 'selected' : '' }}>
                                    {{ $statusLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payment_status" class="form-label">{{ __('order.payment_status') }}</label>
                        <select id="payment_status" name="payment_status" class="form-select">
                            @foreach($viewData['paymentStatuses'] as $statusKey => $statusLabel)
                                <option value="{{ $statusKey }}"
                                    {{ old('payment_status', $viewData['order']->getPaymentStatus()) === $statusKey ? 'selected' : '' }}>
                                    {{ $statusLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($viewData['order']->getItems()->isNotEmpty())
                        <div class="mb-3">
                            <label class="form-label">{{ __('order.items') }}</label>
                            <div style="border: 1px solid var(--c-border); border-radius: var(--radius-md); overflow: hidden;">
                                @foreach($viewData['order']->getItems() as $item)
                                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; border-bottom: 1px solid var(--c-border); font-size: 0.88rem;">
                                        <div>
                                            <span style="font-weight: 600;">{{ $item->getDisplayName() }}</span>
                                            <span style="color: var(--c-muted); margin-left: 0.5rem;">× {{ $item->getQuantity() }}</span>
                                            @if($item->isService())
                                                <span class="pill pill-category" style="margin-left: 0.5rem;">
                                                    {{ __('order.service_item') }}
                                                </span>
                                            @endif
                                        </div>
                                        <span style="font-family: var(--font-mono); color: var(--c-accent-dk);">
                                            {{ $item->getFormattedSubtotal() }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="admin-form-actions">
                        <button type="submit" class="admin-btn-primary">
                            <i class="bi bi-check-lg" aria-hidden="true"></i> {{ __('order.update_button') }}
                        </button>
                        <a href="{{ route('admin.order.index') }}" class="admin-btn-secondary">
                            {{ __('order.back_button') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

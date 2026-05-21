{{-- Author: Emily Cardona Castañeda --}}
@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')

{{-- Stats --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="dashboard-stat-head">
           <div class="stat-card-icon"><i class="bi bi-flower1"></i></div>
        </div>
        <div class="stat-card-value">{{ $viewData['plantsCount'] }}</div>
        <div class="stat-card-label">{{ __('admin.stat_total_plants') }}</div>
    </div>
    <div class="stat-card">
        <div class="dashboard-stat-head">
            <div class="stat-card-icon"><i class="bi bi-check-circle"></i></div>
        </div>
        <div class="stat-card-value">{{ $viewData['activePlantsCount'] }}</div>
        <div class="stat-card-label">{{ __('admin.stat_active') }}</div>
    </div>
    <div class="stat-card">
        <div class="dashboard-stat-head">
            <div class="stat-card-icon"><i class="bi bi-scissors"></i></div>
        </div>
        <div class="stat-card-value">{{ $viewData['servicesCount'] }}</div>
        <div class="stat-card-label">{{ __('admin.stat_active_services') }}</div>
    </div>
    <div class="stat-card">
        <div class="dashboard-stat-head">
            <div class="stat-card-icon"><i class="bi bi-bag-check"></i></div>
        </div>
        <div class="stat-card-value">{{ $viewData['ordersCount'] }}</div>
        <div class="stat-card-label">{{ __('admin.stat_total_orders') }}</div>
    </div>
    <div class="stat-card">
        <div class="dashboard-stat-head">
            <div class="stat-card-icon"><i class="bi bi-clock-history"></i></div>
        </div>
        <div class="stat-card-value">{{ $viewData['pendingOrdersCount'] }}</div>
        <div class="stat-card-label">{{ __('admin.stat_pending') }}</div>
    </div>
    <div class="stat-card">
        <div class="dashboard-stat-head">
            <div class="stat-card-icon"><i class="bi bi-people"></i></div>
        </div>
        <div class="stat-card-value">{{ $viewData['usersCount'] }}</div>
        <div class="stat-card-label">{{ __('admin.stat_registered_users') }}</div>
    </div>
</div>

{{-- Módulos --}}
<span class="section-eyebrow">Gestión</span>
<h2 class="section-title-italic">Módulos <em>del sistema</em></h2>

<div class="dashboard-modules">

    @if(Route::has('admin.plant.index'))
    <div class="dashboard-module">
        <div class="dashboard-module-icon"><i class="bi bi-flower1"></i></div>
        <h3>{{ __('admin.module_plants') }}</h3>
        <p>{{ __('admin.module_plants_desc') }}</p>
        <div style="display:flex; gap:.6rem; margin-top:auto;">
            <a href="{{ route('admin.plant.index') }}" class="admin-btn-secondary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                {{ __('admin.module_plants_link') }} <i class="bi bi-arrow-right"></i>
            </a>
            <a href="{{ route('admin.plant.create') }}" class="admin-btn-primary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                <i class="bi bi-plus-lg"></i> Nueva
            </a>
        </div>
    </div>
    @endif

    @if(Route::has('admin.category.index'))
    <div class="dashboard-module">
        <div class="dashboard-module-icon"><i class="bi bi-tags"></i></div>
        <h3>{{ __('admin.module_categories') }}</h3>
        <p>{{ __('admin.module_categories_desc') }}</p>
        <div style="display:flex; gap:.6rem; margin-top:auto;">
            <a href="{{ route('admin.category.index') }}" class="admin-btn-secondary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                {{ __('admin.module_categories_link') }} <i class="bi bi-arrow-right"></i>
            </a>
            <a href="{{ route('admin.category.create') }}" class="admin-btn-primary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                <i class="bi bi-plus-lg"></i> Nueva
            </a>
        </div>
    </div>
    @endif

    @if(Route::has('admin.service.index'))
    <div class="dashboard-module">
        <div class="dashboard-module-icon"><i class="bi bi-scissors"></i></div>
        <h3>{{ __('admin.module_services') }}</h3>
        <p>{{ __('admin.module_services_desc') }}</p>
        <div style="display:flex; gap:.6rem; margin-top:auto;">
            <a href="{{ route('admin.service.index') }}" class="admin-btn-secondary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                {{ __('admin.module_services_link') }} <i class="bi bi-arrow-right"></i>
            </a>
            <a href="{{ route('admin.service.create') }}" class="admin-btn-primary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                <i class="bi bi-plus-lg"></i> Nuevo
            </a>
        </div>
    </div>
    @endif

    @if(Route::has('admin.order.index'))
    <div class="dashboard-module">
        <div class="dashboard-module-icon"><i class="bi bi-bag-check"></i></div>
        <h3>{{ __('admin.module_orders') }}</h3>
        <p>{{ __('admin.module_orders_desc') }}</p>
        <div style="display:flex; gap:.6rem; margin-top:auto;">
            <a href="{{ route('admin.order.index') }}" class="admin-btn-secondary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                {{ __('admin.module_orders_link') }} <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif

    @if(Route::has('admin.user.index'))
    <div class="dashboard-module">
        <div class="dashboard-module-icon"><i class="bi bi-people"></i></div>
        <h3>{{ __('admin.module_users') }}</h3>
        <p>{{ __('admin.module_users_desc') }}</p>
        <div style="display:flex; gap:.6rem; margin-top:auto;">
            <a href="{{ route('admin.user.index') }}" class="admin-btn-secondary"
               style="padding:.6rem 1rem; font-size:.7rem;">
                {{ __('admin.module_users_link') }} <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif

</div>

{{-- Pedidos recientes --}}
@if($viewData['recentOrders']->isNotEmpty())
<div class="dashboard-recent">
    <div class="dashboard-recent-header">
        <div>
            <span class="section-eyebrow">Operaciones</span>
            <h2 class="section-title-italic">{{ __('admin.recent_orders') }}</h2>
        </div>
        @if(Route::has('admin.order.index'))
        <a href="{{ route('admin.order.index') }}" class="admin-btn-secondary"
           style="padding:.6rem 1rem; font-size:.7rem;">
            {{ __('admin.view_all') }} <i class="bi bi-arrow-right"></i>
        </a>
        @endif
    </div>

    <div class="admin-data-table">
        <table>
            <thead>
                <tr>
                    <th>{{ __('admin.col_order') }}</th>
                    <th>{{ __('admin.col_client') }}</th>
                    <th>{{ __('admin.col_total') }}</th>
                    <th>{{ __('admin.col_status') }}</th>
                    <th>{{ __('admin.col_date') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['recentOrders'] as $order)
                <tr>
                    <td class="cell-id">#{{ $order->getId() }}</td>
                    <td>
                        <span class="cell-primary">{{ $order->getUser()?->getName() ?? '—' }}</span>
                        <span class="cell-secondary">{{ $order->getUser()?->getEmail() }}</span>
                    </td>
                    <td class="cell-price">{{ $order->getFormattedTotal() }}</td>
                    <td>
                        @php $status = $order->getStatus(); @endphp
                        @if($status === 'pending')
                            <span class="pill pill-pending">{{ $status }}</span>
                        @elseif($status === 'completed')
                            <span class="pill pill-active">{{ $status }}</span>
                        @elseif($status === 'cancelled')
                            <span class="pill pill-inactive">{{ $status }}</span>
                        @else
                            <span class="pill pill-category">{{ $status }}</span>
                        @endif
                    </td>
                    <td style="font-size:.78rem; color:var(--c-muted);">
                        {{ $order->getFormattedDate() }}
                    </td>
                    <td>
                        @if(Route::has('admin.order.edit'))
                        <a href="{{ route('admin.order.edit', $order->getId()) }}"
                           class="btn-row-edit">
                            <i class="bi bi-pencil"></i> {{ __('admin.action_edit') }}
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

{{-- Author: Emily Cardona Castañeda --}}

@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-text">
        <h1>{{ __('service.admin_list_title') }} <em>{{ __('service.admin_list_subtitle') }}</em></h1>
    </div>
    <a href="{{ route('admin.service.create') }}" class="admin-btn-primary">
        <i class="bi bi-plus-lg" aria-hidden="true"></i> {{ __('service.create_btn') }}
    </a>
</div>

@if($viewData['services']->isEmpty())
    <div class="admin-empty">
        <i class="bi bi-scissors" aria-hidden="true"></i>
        <h3>{{ __('service.empty_admin') }}</h3>
        <p>{{ __('service.empty_description') }}</p>
    </div>
@else
    <div class="admin-data-table">
        <table>
            <thead>
                <tr>
                    <th>{{ __('service.col_id') }}</th>
                    <th>{{ __('service.col_name') }}</th>
                    <th>{{ __('service.col_employee') }}</th>
                    <th>{{ __('service.col_price') }}</th>
                    <th>{{ __('service.col_duration') }}</th>
                    <th>{{ __('service.col_active') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['services'] as $service)
                    <tr>
                        <td class="cell-id">{{ $service->getId() }}</td>
                        <td>
                            <span class="cell-primary">{{ $service->getName() }}</span>
                            @if($service->getDescription())
                                <span class="cell-secondary">{{ Str::limit($service->getDescription(), 50) }}</span>
                            @endif
                        </td>
                        <td>{{ $service->getEmployee() ?? '—' }}</td>
                        <td class="cell-price">{{ $service->getFormattedPrice() }}</td>
                        <td>{{ $service->getDuration() ?? '—' }}</td>
                        <td>
                            @if($service->getActive())
                                <span class="pill pill-active">{{ __('service.status_active') }}</span>
                            @else
                                <span class="pill pill-inactive">{{ __('service.status_inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.service.edit', $service->getId()) }}" class="btn-row-edit">
                                    <i class="bi bi-pencil" aria-hidden="true"></i> {{ __('service.action_edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.service.destroy', $service->getId()) }}" class="delete-form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-row-delete"
                                            onclick="return confirm('{{ __('service.confirm_delete') }}')">
                                        <i class="bi bi-trash" aria-hidden="true"></i> {{ __('service.action_delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection

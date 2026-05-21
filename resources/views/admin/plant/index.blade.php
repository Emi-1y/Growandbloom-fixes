{{-- Author: Emily Cardona Castañeda --}}

@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-text">
        <h1>{{ __('plant.admin_list_title') }} <em>{{ __('plant.admin_list_subtitle') }}</em></h1>
    </div>
    <a href="{{ route('admin.plant.create') }}" class="admin-btn-primary">
        <i class="bi bi-plus-lg" aria-hidden="true"></i> {{ __('plant.create_btn') }}
    </a>
</div>

@if($viewData['plants']->isEmpty())
    <div class="admin-empty">
        <i class="bi bi-flower1" aria-hidden="true"></i>
        <h3>{{ __('plant.empty') }}</h3>
        <p>{{ __('plant.empty_description') }}</p>
    </div>
@else
    <div class="admin-data-table">
        <table>
            <thead>
                <tr>
                    <th>{{ __('plant.col_id') }}</th>
                    <th>{{ __('plant.col_name') }}</th>
                    <th>{{ __('plant.col_category') }}</th>
                    <th>{{ __('plant.col_price') }}</th>
                    <th>{{ __('plant.col_stock') }}</th>
                    <th>{{ __('plant.col_active') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($viewData['plants'] as $plant)
                    <tr>
                        <td class="cell-id">{{ $plant->getId() }}</td>
                        <td>
                            <span class="cell-primary">{{ $plant->getName() }}</span>
                            @if($plant->getDescription())
                                <span class="cell-secondary">{{ Str::limit($plant->getDescription(), 50) }}</span>
                            @endif
                        </td>
                        <td><span class="pill pill-category">{{ $plant->getCategory()->getName() }}</span></td>
                        <td class="cell-price">{{ $plant->getFormattedPrice() }}</td>
                        <td>
                            <span class="stock-value {{ $plant->getStock() > 0 ? 'in-stock' : 'out-stock' }}">
                                {{ $plant->getStock() }}
                            </span>
                        </td>
                        <td>
                            @if($plant->getActive())
                                <span class="pill pill-active">{{ __('plant.status_active') }}</span>
                            @else
                                <span class="pill pill-inactive">{{ __('plant.status_inactive') }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.plant.edit', $plant->getId()) }}" class="btn-row-edit">
                                    <i class="bi bi-pencil" aria-hidden="true"></i> {{ __('plant.action_edit') }}
                                </a>
                                <form method="POST" action="{{ route('admin.plant.destroy', $plant->getId()) }}" class="delete-form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-row-delete"
                                            onclick="return confirm('{{ __('plant.confirm_delete') }}')">
                                        <i class="bi bi-trash" aria-hidden="true"></i> {{ __('plant.action_delete') }}
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

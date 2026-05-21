{{-- Author: Emily Cardona Castañeda --}}

@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@section('content')
<div class="admin-page-header">
    <div class="admin-page-header-text">
        <h1>{{ __('category.admin_list_title') }} <em>{{ __('category.admin_list_subtitle') }}</em></h1>
    </div>
    <a href="{{ route('admin.category.create') }}" class="admin-btn-primary">
        <i class="bi bi-plus-lg"></i> {{ __('category.create_button') }}
    </a>
</div>

@if($viewData['categories']->isEmpty())
    <div class="admin-empty">
        <i class="bi bi-tags" aria-hidden="true"></i>
        <h3>{{ __('category.empty') }}</h3>
        <p>{{ __('category.empty_description') }}</p>
        <a href="{{ route('admin.category.create') }}" class="admin-btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('category.create_button') }}
        </a>
    </div>
@else
    <div class="dashboard-modules">
        @foreach($viewData['categories'] as $category)
            <div class="dashboard-module">
                <div class="dashboard-module-icon">
                    <i class="bi bi-tag-fill" aria-hidden="true"></i>
                </div>
                <h3>{{ $category->getName() }}</h3>
                <p>{{ $category->getDescription() ? Str::limit($category->getDescription(), 100) : '—' }}</p>
                <div class="row-actions" style="justify-content: flex-start;">
                    <a href="{{ route('admin.category.edit', $category->getId()) }}" class="btn-row-edit">
                        <i class="bi bi-pencil" aria-hidden="true"></i> {{ __('category.edit_button') }}
                    </a>
                    <form method="POST" action="{{ route('admin.category.destroy', $category->getId()) }}" class="delete-form-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-row-delete"
                                onclick="return confirm('{{ __('category.confirm_delete') }}')">
                            <i class="bi bi-trash" aria-hidden="true"></i> {{ __('category.delete_button') }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection

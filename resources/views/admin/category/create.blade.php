{{-- Author: Emily Cardona Castañeda --}}
@extends('layouts.admin')

@section('title', $viewData['title'])
@section('subtitle', $viewData['subtitle'])

@push('header-actions')
    <a href="{{ route('admin.category.index') }}" class="admin-btn-secondary">
        <i class="bi bi-arrow-left" aria-hidden="true"></i> {{ __('category.back_button') }}
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

                <form method="POST" action="{{ route('admin.category.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('category.name') }}</label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">{{ __('category.description') }}</label>
                        <textarea id="description" name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="admin-form-actions">
                        <button type="submit" class="admin-btn-primary">
                            <i class="bi bi-check-lg" aria-hidden="true"></i> {{ __('category.save_button') }}
                        </button>
                        <a href="{{ route('admin.category.index') }}" class="admin-btn-secondary">
                            {{ __('category.back_button') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

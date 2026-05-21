{{-- Author: Emily Cardona Castañeda --}}
<div class="row g-3">

    <div class="col-12">
        <label for="name" class="form-label">{{ __('service.form_name') }}</label>
        <input type="text" id="name" name="name" class="form-control"
               placeholder="{{ __('service.form_name_placeholder') }}"
               value="{{ old('name', $service?->getName()) }}">
    </div>

    <div class="col-md-6">
        <label for="price" class="form-label">{{ __('service.form_price') }}</label>
        <input type="number" id="price" name="price" class="form-control" min="0"
               placeholder="180000"
               value="{{ old('price', $service?->getPrice()) }}">
    </div>

    <div class="col-md-6">
        <label for="duration" class="form-label">{{ __('service.form_duration') }}</label>
        <input type="text" id="duration" name="duration" class="form-control"
               placeholder="{{ __('service.form_duration_placeholder') }}"
               value="{{ old('duration', $service?->getDuration()) }}">
    </div>

    <div class="col-12">
        <label for="employee" class="form-label">{{ __('service.form_employee') }}</label>
        <input type="text" id="employee" name="employee" class="form-control"
               placeholder="{{ __('service.form_employee_placeholder') }}"
               value="{{ old('employee', $service?->getEmployee()) }}">
    </div>

    <div class="col-12">
        <label for="description" class="form-label">{{ __('service.form_description') }}</label>
        <textarea id="description" name="description" class="form-control" rows="3"
                  placeholder="{{ __('service.form_description_placeholder') }}"
        >{{ old('description', $service?->getDescription()) }}</textarea>
    </div>

    <div class="col-12">
        <label for="features_text" class="form-label">{{ __('service.form_features') }}</label>
        <textarea id="features_text" name="features_text" class="form-control" rows="5"
                  placeholder="{{ __('service.form_features_placeholder') }}"
        >{{ old('features_text', $service ? implode("\n", $service->getFeatures()) : '') }}</textarea>
        <small class="text-muted" style="font-size:.78rem; display:block; margin-top:.3rem;">
            {{ __('service.form_features_hint') }}
        </small>
    </div>

    <div class="col-12">
        <label for="image" class="form-label">{{ __('service.form_image') }}</label>
        <input type="text" id="image" name="image" class="form-control"
               placeholder="{{ __('service.form_image_placeholder') }}"
               value="{{ old('image', $service?->getImage()) }}">
    </div>

    <div class="col-12">
        <div class="form-check">
            <input type="checkbox" id="active" name="active" value="1"
                   class="form-check-input"
                   {{ old('active', $service?->getActive() ?? true) ? 'checked' : '' }}>
            <label for="active" class="form-check-label">{{ __('service.form_active') }}</label>
        </div>
    </div>

    <div class="col-12">
        <div class="admin-form-actions">
            <button type="submit" class="admin-btn-primary">
                <i class="bi bi-check-lg" aria-hidden="true"></i> {{ $submitText }}
            </button>
            <a href="{{ route('admin.service.index') }}" class="admin-btn-secondary">
                {{ __('service.form_back') }}
            </a>
        </div>
    </div>

</div>

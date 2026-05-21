<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->boolean('active'),
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'employee' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'price' => 'required|integer|min:0',
            'duration' => 'nullable|string|max:100',
            'active' => 'required|boolean',
            'features_text' => 'nullable|string|max:2000',
        ];
    }
}

<?php

// Author: Emily Cardona Castañeda

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'item_type' => $this->input('item_type', 'plant'),
        ]);
    }

    public function rules(): array
    {
        return [
            'item_type' => ['required', 'string', 'in:plant,service'],
            'plant_id' => ['nullable', 'integer', 'required_if:item_type,plant', Rule::exists('plants', 'id')->where('active', true)],
            'quantity' => ['nullable', 'integer', 'min:1', 'required_if:item_type,plant'],
            'service_id' => ['nullable', 'integer', 'required_if:item_type,service', Rule::exists('services', 'id')->where('active', true)],
        ];
    }
}

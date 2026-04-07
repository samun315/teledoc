<?php

namespace App\Http\Requests\PaymentMode;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentModeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_image' => 'nullable|boolean',
            'account_details' => 'required|string|max:16777215',
            'instruction' => 'required|string|max:16777215',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'sometimes|boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('is_active')) {
            $this->merge([
                'is_active' => filter_var($this->input('is_active'), FILTER_VALIDATE_BOOLEAN),
            ]);
        }
    }
}

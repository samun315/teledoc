<?php

namespace App\Http\Requests\PaymentTermItem;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentTermItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:16777215',
            'icon' => 'required|string|max:120',
            'icon_color' => 'required|in:blue,green,orange,red,purple',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'sometimes|boolean',
        ];
    }
}

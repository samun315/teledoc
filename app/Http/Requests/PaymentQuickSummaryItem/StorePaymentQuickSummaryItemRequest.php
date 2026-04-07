<?php

namespace App\Http\Requests\PaymentQuickSummaryItem;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentQuickSummaryItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'line_text' => 'required|string|max:500',
            'badge_variant' => 'required|integer|min:1|max:5',
            'sort_order' => 'nullable|integer|min:0|max:65535',
            'is_active' => 'sometimes|boolean',
        ];
    }
}

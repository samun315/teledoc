<?php

namespace App\Http\Requests\PaymentInstructionHero;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentInstructionHeroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:65535',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:Active,Inactive',
        ];
    }
}

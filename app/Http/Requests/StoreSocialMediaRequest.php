<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:255',
            'icon_class' => 'nullable|string|max:100',
            'display_location' => 'required|in:header,footer,both',
            'order' => 'nullable|integer|min:0',
            'active' => 'required|in:YES,NO',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'platform' => 'platform',
            'url' => 'URL',
            'icon_class' => 'icon class',
            'display_location' => 'display location',
            'order' => 'order',
            'active' => 'status',
        ];
    }
}


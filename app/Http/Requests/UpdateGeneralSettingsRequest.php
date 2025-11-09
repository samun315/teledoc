<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingsRequest extends FormRequest
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
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'copyright_text' => 'required|string|max:500',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'google_analytics' => 'nullable|string',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'site_name' => 'site name',
            'site_tagline' => 'site tagline',
            'copyright_text' => 'copyright text',
            'meta_description' => 'meta description',
            'meta_keywords' => 'meta keywords',
            'google_analytics' => 'Google Analytics code',
        ];
    }
}


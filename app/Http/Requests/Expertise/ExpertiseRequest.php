<?php

namespace App\Http\Requests\Expertise;

use Illuminate\Foundation\Http\FormRequest;

class ExpertiseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'item_1_icon' => 'nullable|string|max:100',
            'item_1_title' => 'nullable|string|max:255',
            'item_1_description' => 'nullable|string',
            'item_1_link' => 'nullable|string|max:255',
            'item_2_icon' => 'nullable|string|max:100',
            'item_2_title' => 'nullable|string|max:255',
            'item_2_description' => 'nullable|string',
            'item_2_link' => 'nullable|string|max:255',
            'item_3_icon' => 'nullable|string|max:100',
            'item_3_title' => 'nullable|string|max:255',
            'item_3_description' => 'nullable|string',
            'item_3_link' => 'nullable|string|max:255',
            'item_4_icon' => 'nullable|string|max:100',
            'item_4_title' => 'nullable|string|max:255',
            'item_4_description' => 'nullable|string',
            'item_4_link' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'image.image' => 'The image must be an image file.',
            'image.mimes' => 'The image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'image.max' => 'The image cannot exceed 2MB.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
        ];
    }
}


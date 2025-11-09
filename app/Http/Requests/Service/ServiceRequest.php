<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'icon' => 'nullable|string|max:100',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'detail_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'meta_description' => 'nullable|string|max:160',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The service title is required.',
            'title.max' => 'The service title cannot exceed 255 characters.',
            'short_description.required' => 'The short description is required.',
            'content.required' => 'The service content is required.',
            'banner_image.image' => 'The banner image must be an image file.',
            'banner_image.mimes' => 'The banner image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'banner_image.max' => 'The banner image cannot exceed 2MB.',
            'detail_image.image' => 'The detail image must be an image file.',
            'detail_image.mimes' => 'The detail image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'detail_image.max' => 'The detail image cannot exceed 2MB.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
            'order.integer' => 'The order must be a number.',
            'order.min' => 'The order must be at least 0.',
            'meta_description.max' => 'The meta description cannot exceed 160 characters.',
        ];
    }
}


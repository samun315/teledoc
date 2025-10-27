<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'shape_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'button_text_1' => 'nullable|string|max:100',
            'button_url_1' => 'nullable|string|max:255',
            'button_text_2' => 'nullable|string|max:100',
            'button_url_2' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The slider title is required.',
            'title.max' => 'The slider title cannot exceed 255 characters.',
            'image.image' => 'The slider image must be an image file.',
            'image.mimes' => 'The slider image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'image.max' => 'The slider image cannot exceed 2MB.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
            'order.integer' => 'The order must be a number.',
            'order.min' => 'The order must be at least 0.',
        ];
    }
}


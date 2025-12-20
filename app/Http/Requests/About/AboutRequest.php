<?php

namespace App\Http\Requests\About;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
        $aboutId = $this->route('about_id');
        
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'left_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'right_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'feature_1' => 'nullable|string|max:255',
            'feature_2' => 'nullable|string|max:255',
            'feature_3' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
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
            'description.required' => 'The description is required.',
            'left_image.image' => 'The left image must be an image file.',
            'left_image.mimes' => 'The left image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'left_image.max' => 'The left image cannot exceed 2MB.',
            'right_image.image' => 'The right image must be an image file.',
            'right_image.mimes' => 'The right image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'right_image.max' => 'The right image cannot exceed 2MB.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
        ];
    }
}


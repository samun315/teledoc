<?php

namespace App\Http\Requests\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
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
            'patient_name' => 'required|string|max:255',
            'patient_designation' => 'nullable|string|max:100',
            'testimonial_text' => 'required|string',
            'patient_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'rating' => 'nullable|integer|min:1|max:5',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:Active,Inactive',
            'is_featured' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'patient_name.required' => 'The patient name is required.',
            'patient_name.max' => 'The patient name cannot exceed 255 characters.',
            'testimonial_text.required' => 'The testimonial text is required.',
            'patient_image.image' => 'The patient image must be an image file.',
            'patient_image.mimes' => 'The patient image must be a JPEG, PNG, JPG, GIF, or WEBP file.',
            'patient_image.max' => 'The patient image cannot exceed 2MB.',
            'rating.integer' => 'The rating must be a number.',
            'rating.min' => 'The rating must be at least 1.',
            'rating.max' => 'The rating cannot exceed 5.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
            'order.integer' => 'The order must be a number.',
            'order.min' => 'The order must be at least 0.',
        ];
    }
}


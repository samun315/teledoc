<?php

namespace App\Http\Requests\Speciality;

use Illuminate\Foundation\Http\FormRequest;

class SpecialityRequest extends FormRequest
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
            'description' => 'required|string',
            'icon' => 'nullable|string|max:100',
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
            'title.required' => 'The speciality title is required.',
            'title.max' => 'The speciality title cannot exceed 255 characters.',
            'description.required' => 'The description is required.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
            'order.integer' => 'The order must be a number.',
            'order.min' => 'The order must be at least 0.',
        ];
    }
}


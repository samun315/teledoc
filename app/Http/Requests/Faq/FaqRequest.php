<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
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
            'question.required' => 'The question is required.',
            'question.max' => 'The question cannot exceed 500 characters.',
            'answer.required' => 'The answer is required.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Active or Inactive.',
            'order.integer' => 'The order must be a number.',
            'order.min' => 'The order must be at least 0.',
        ];
    }
}


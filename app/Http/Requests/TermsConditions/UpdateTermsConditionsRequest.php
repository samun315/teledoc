<?php

namespace App\Http\Requests\TermsConditions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTermsConditionsRequest extends FormRequest
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
            'terms_conditions' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'terms_conditions.required' => 'The terms and conditions content is required.',
        ];
    }
}

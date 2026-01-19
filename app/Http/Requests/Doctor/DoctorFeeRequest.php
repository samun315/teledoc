<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorFeeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'consultation_fee' => 'required|numeric|min:0',
            'platform_commission' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'consultation_fee.required' => 'Consultation fee is required.',
            'consultation_fee.numeric' => 'Consultation fee must be a number.',
            'consultation_fee.min' => 'Consultation fee must be at least 0.',
            'platform_commission.required' => 'Platform commission is required.',
            'platform_commission.numeric' => 'Platform commission must be a number.',
            'platform_commission.min' => 'Platform commission must be at least 0.',
            'platform_commission.max' => 'Platform commission cannot exceed 100.',
        ];
    }

    public function fields(): array
    {
        return [
            'consultation_fee' => $this->input('consultation_fee'),
            'platform_commission' => $this->input('platform_commission'),
            'updated_by' => loggedInUserId(),
            'updated_at' => createdAtDateConvertToDB(),
        ];
    }
}

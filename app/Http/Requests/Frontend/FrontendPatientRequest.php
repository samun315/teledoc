<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class FrontendPatientRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:patients,email|unique:users,email',
            'phone' => 'required|string|max:20|unique:patients,phone|unique:users,phone',
            'password' => 'required|min:6|confirmed',
            'date_of_birth' => 'required|date|before:today',
            'age' => 'nullable|numeric|min:0|max:150',
            'height' => 'nullable|string|max:50',
            'weight' => 'nullable|string|max:50',
            'gender' => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'marital_status' => 'nullable|in:Married,Unmarried,Others',
            'address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
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
            'name.required' => 'Full name is required.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number is already registered.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'photo.image' => 'Photo must be an image file.',
            'photo.max' => 'Photo size must not exceed 2MB.',
        ];
    }

    /**
     * Get the validated data in the format needed for patient creation.
     *
     * @return array
     */
    public function getPatientData(): array
    {
        $data = [
            'name' => $this->input('name'),
            'email' => $this->input('email') ?? null,
            'phone' => $this->input('phone'),
            'date_of_birth' => $this->input('date_of_birth'),
            'age' => $this->input('age') ?? null,
            'height' => $this->input('height') ?? null,
            'weight' => $this->input('weight') ?? null,
            'gender' => $this->input('gender') ?? null,
            'blood_group' => $this->input('blood_group') ?? null,
            'marital_status' => $this->input('marital_status') ?? null,
            'address' => $this->input('address') ?? null,
            'password' => $this->input('password'),
        ];

        return $data;
    }
}

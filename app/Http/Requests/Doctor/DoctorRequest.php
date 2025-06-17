<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
        $validationData = [];
        //Basic Information

        if ($this->input('doctor_id')) {

            $doctorId = $this->input('doctor_id');

            $validationData['photo'] = 'nullable';
            $validationData['title'] = 'nullable';
            $validationData['name'] = 'nullable';
            $validationData['email'] = 'nullable|email|unique:doctors,email,' . $doctorId . ',doctor_id';
            $validationData['phone'] = 'nullable|unique:doctors,phone,' . $doctorId . ',doctor_id';
            $validationData['department_id'] = 'nullable';
            $validationData['description'] = 'nullable';
            $validationData['address'] = 'nullable';
        } else {
            $validationData['photo'] = 'nullable';
            $validationData['title'] = 'required';
            $validationData['name'] = 'required';
            $validationData['email'] = 'required|email|unique:doctors,email';
            $validationData['phone'] = 'required|unique:doctors,phone';
            $validationData['password'] = 'nullable|min:6';
            $validationData['confirm_password'] = 'nullable|same:password';
            $validationData['department_id'] = 'required';
            $validationData['description'] = 'nullable';
            $validationData['address'] = 'nullable';
        }

        return $validationData;
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['title'] = $this->input('title');
        $inputData['name'] = $this->input('name');
        $inputData['email'] = $this->input('email');
        $inputData['phone'] = $this->input('phone');
        $inputData['department_id'] = $this->input('department_id');
        $inputData['description'] = $this->input('description') ?? null;
        $inputData['address'] = $this->input('address') ?? null;

        if ($this->input('doctor_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['password'] = $this->input('password') ?? null;
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

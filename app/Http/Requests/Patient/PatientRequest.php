<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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

        if ($this->input('patient_id')) {

            $patientId = $this->input('patient_id');

            $validationData['photo'] = 'nullable';
            $validationData['name'] = 'nullable';
            $validationData['email'] = 'nullable|email|unique:patients,email,' . $patientId . ',patient_id';
            $validationData['phone'] = 'nullable|unique:patients,phone,' . $patientId . ',patient_id';
            $validationData['date_of_birth'] = 'nullable';
            $validationData['age'] = 'nullable';
            $validationData['height'] = 'nullable';
            $validationData['weight'] = 'nullable';
            $validationData['gender'] = 'nullable';
            $validationData['blood_group'] = 'nullable';
            $validationData['marital_status'] = 'nullable';
            $validationData['note'] = 'nullable';
            $validationData['address'] = 'nullable';
        } else {
            $validationData['photo'] = 'nullable';
            $validationData['name'] = 'required';
            $validationData['email'] = 'nullable|email|unique:patients,email|unique:users,email';
            $validationData['phone'] = 'required|unique:patients,phone|unique:users,phone';
            $validationData['password'] = 'nullable|min:6';
            $validationData['confirm_password'] = 'nullable|same:password';
            $validationData['date_of_birth'] = 'nullable';
            $validationData['age'] = 'nullable';
            $validationData['height'] = 'nullable';
            $validationData['weight'] = 'nullable';
            $validationData['gender'] = 'nullable';
            $validationData['blood_group'] = 'nullable';
            $validationData['marital_status'] = 'nullable';
            $validationData['note'] = 'nullable';
            $validationData['address'] = 'nullable';
        }

        return $validationData;
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['name'] = $this->input('name');
        $inputData['email'] = $this->input('email') ?? null;
        $inputData['phone'] = $this->input('phone');
        $inputData['date_of_birth'] = $this->input('date_of_birth') ? dateConvertFormToDB($this->input('date_of_birth')) : null;
        $inputData['age'] = $this->input('age') ?? null;
        $inputData['height'] = $this->input('height') ?? null;
        $inputData['weight'] = $this->input('weight') ?? null;
        $inputData['gender'] = $this->input('gender') ?? null;
        $inputData['blood_group'] = $this->input('blood_group') ?? null;
        $inputData['marital_status'] = $this->input('marital_status') ?? null;
        $inputData['note'] = $this->input('note') ?? null;
        $inputData['address'] = $this->input('address') ?? null;

        if ($this->input('patient_id')) {
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

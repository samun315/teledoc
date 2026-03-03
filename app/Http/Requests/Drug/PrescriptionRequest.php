<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            'doctor_id' => 'required',
            'prescription_date' => 'nullable',
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['subscription_type_id'] = $this->input('subscription_type_id');
        $inputData['subscription_details'] = $this->input('subscription_details') ?? null;

        $inputData['drug_type_id'] = $this->input('drug_type_id');
        $inputData['drug_id'] = $this->input('drug_id');
        $inputData['drug_strength_id'] = $this->input('drug_strength_id');
        $inputData['drug_dose_id'] = $this->input('drug_dose_id');
        $inputData['drug_duration_id'] = $this->input('drug_duration_id');
        $inputData['drug_advice_id'] = $this->input('drug_advice_id');


        $inputData['prescription_date'] = $this->input('prescription_date');
        $inputData['doctor_id'] = $this->input('doctor_id');
        $inputData['patient_id'] = $this->input('patient_id');
        $inputData['appointment_id'] = $this->input('appointment_id');
        $inputData['doctor_advice'] = $this->input('doctor_advice');
        $inputData['follow_up'] = $this->input('follow_up');

        $inputData['created_by'] = loggedInUserId();
        $inputData['created_at'] = createdAtDateConvertToDB();
        $inputData['updated_by'] = loggedInUserId();
        $inputData['updated_at'] = createdAtDateConvertToDB();

        return $inputData;
    }
}

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
            'doctor_id' => 'required|integer|exists:doctors,doctor_id',
            'patient_id' => 'required|integer|exists:patients,patient_id',
            'prescription_date' => 'nullable',
            'appointment_id' => 'nullable|exists:appointments,appointment_id',
            'drug_id' => 'nullable|array',
            'drug_id.*' => 'nullable|integer|exists:drugs,drug_id',
            'drug_type_id' => 'nullable|array',
            'drug_type_id.*' => 'nullable|integer|exists:drug_types,drug_type_id',
            'drug_strength_id' => 'nullable|array',
            'drug_strength_id.*' => 'nullable|integer|exists:drug_strengths,drug_strength_id',
            'drug_dose_id' => 'nullable|array',
            'drug_dose_id.*' => 'nullable|integer|exists:drug_doses,drug_dose_id',
            'drug_duration_id' => 'nullable|array',
            'drug_duration_id.*' => 'nullable|integer|exists:drug_durations,drug_duration_id',
            'drug_advice_id' => 'nullable|array',
            'drug_advice_id.*' => 'nullable|integer|exists:drug_advices,drug_advice_id',
            'subscription_type_id' => 'nullable|array',
            'subscription_type_id.*' => 'nullable|integer|exists:subscription_types,subscription_type_id',
            'subscription_details' => 'nullable|array',
            'subscription_details.*' => 'nullable|string',
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
        $inputData['appointment_id'] = $this->filled('appointment_id')
            ? (int) $this->input('appointment_id')
            : null;
        $inputData['doctor_advice'] = $this->input('doctor_advice');
        $inputData['follow_up'] = $this->input('follow_up');

        $inputData['created_by'] = loggedInUserId();
        $inputData['created_at'] = createdAtDateConvertToDB();
        $inputData['updated_by'] = loggedInUserId();
        $inputData['updated_at'] = createdAtDateConvertToDB();

        return $inputData;
    }
}

<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DoctorAppointmentRequest extends FormRequest
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
            'doctor_id' => ['required', 'exists:doctors,doctor_id'],
            'patient_id' => ['required', 'exists:patients,patient_id'],
            'appointment_date' => ['required', 'date'],
            'slot_id' => ['required'],
            'slot_time' => ['required', 'date_format:H:i'],
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['doctor_id']        = $this->input('doctor_id');
        $inputData['patient_id']       = $this->input('patient_id');
        $inputData['appointment_date'] = $this->input('appointment_date');
        $inputData['slot_id']          = $this->input('slot_id');
        $inputData['slot_time']        = $this->input('slot_time');

        if ($this->input('appointment_id')) {
            // Update mode
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            // Create mode
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

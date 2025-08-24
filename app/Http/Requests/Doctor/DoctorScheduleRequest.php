<?php

namespace App\Http\Requests\Doctor;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorScheduleRequest extends FormRequest
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
            'day_of_week' => 'nullable',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'slot_duration_minutes' => 'nullable',
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['doctor_id'] = $this->input('doctor_id');
        $inputData['day_of_week'] = $this->input('day_of_week'); // array

        $startTimes = $this->input('start_time', []);
        $endTimes   = $this->input('end_time', []);

        $convertedStart = [];
        $convertedEnd   = [];

        foreach ($startTimes as $key => $time) {
            // null check removed, empty string will throw exception if format wrong
            $convertedStart[$key] = Carbon::createFromFormat('h:i A', $time)->format('H:i:s');
        }

        foreach ($endTimes as $key => $time) {
            $convertedEnd[$key] = Carbon::createFromFormat('h:i A', $time)->format('H:i:s');
        }

        $inputData['start_time'] = $convertedStart;
        $inputData['end_time']   = $convertedEnd;

        $inputData['slot_duration_minutes'] = $this->input('slot_duration_minutes'); // array

        $inputData['schedule_id'] = $this->input('schedule_id') ?? null;

        $inputData['updated_by'] = loggedInUserId();
        $inputData['updated_at'] = createdAtDateConvertToDB();

        $inputData['created_by'] = loggedInUserId();
        $inputData['created_at'] = createdAtDateConvertToDB();


        return $inputData;
    }
}

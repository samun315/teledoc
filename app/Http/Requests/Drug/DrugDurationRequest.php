<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DrugDurationRequest extends FormRequest
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
        if ($this->input('drug_duration_id')) {
            return [
                'drug_duration' => [
                    'required',
                    Rule::unique('drug_durations')->ignore($this->input('drug_duration_id'), 'drug_duration_id')
                ],
                'status' => 'required|max:8'
            ];
        }

        return [
            'drug_duration' => 'required|unique:drug_durations',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['drug_duration'] = $this->input('drug_duration');
        $inputData['status'] = $this->input('status');

        if ($this->input('drug_duration_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

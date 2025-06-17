<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorDepartmentRequest extends FormRequest
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
        if ($this->input('department_id')) {
            return [
                'department_name' => [
                    'required',
                    Rule::unique('departments')->ignore($this->input('department_id'), 'department_id')
                ],
                'status' => 'required|max:8',
                'description' => 'nullable'
            ];
        }

        return [
            'department_name' => 'required|unique:departments',
            'status' => 'required|max:8',
            'description' => 'nullable'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['department_name'] = $this->input('department_name');
        $inputData['description'] = $this->input('description');
        $inputData['status'] = $this->input('status');

        if ($this->input('department_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

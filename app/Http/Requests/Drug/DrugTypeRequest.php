<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DrugTypeRequest extends FormRequest
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
        if ($this->input('drug_type_id')) {
            return [
                'drug_type' => [
                    'required',
                    Rule::unique('drug_types')->ignore($this->input('drug_type_id'), 'drug_type_id')
                ],
                'status' => 'required|max:8'
            ];
        }

        return [
            'drug_type' => 'required|unique:drug_types',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['drug_type'] = $this->input('drug_type');
        $inputData['status'] = $this->input('status');

        if ($this->input('drug_type_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

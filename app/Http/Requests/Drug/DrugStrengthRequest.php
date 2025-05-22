<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DrugStrengthRequest extends FormRequest
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
        if ($this->input('drug_strength_id')) {
            return [
                'drug_strength' => [
                    'required',
                    Rule::unique('drug_strengths')->ignore($this->input('drug_strength_id'), 'drug_strength_id')
                ],
                'status' => 'required|max:8'
            ];
        }

        return [
            'drug_strength' => 'required|unique:drug_strengths',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['drug_strength'] = $this->input('drug_strength');
        $inputData['status'] = $this->input('status');

        if ($this->input('drug_strength_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

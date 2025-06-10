<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DrugAdviceRequest extends FormRequest
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
        if ($this->input('drug_advice_id')) {
            return [
                'drug_advice' => [
                    'required',
                    Rule::unique('drug_advices')->ignore($this->input('drug_advice_id'), 'drug_advice_id')
                ],
                'status' => 'required|max:8'
            ];
        }

        return [
            'drug_advice' => 'required|unique:drug_advices',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['drug_advice'] = $this->input('drug_advice');
        $inputData['status'] = $this->input('status');

        if ($this->input('drug_advice_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

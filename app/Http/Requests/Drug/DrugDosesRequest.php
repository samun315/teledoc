<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DrugDosesRequest extends FormRequest
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
        // if ($this->input('drug_dose_id')) {
        //     return [
        //         'drug_dose' => [
        //             'required',
        //             Rule::unique('drug_doses')->ignore($this->input('drug_dose_id'), 'drug_dose_id')
        //         ],
        //         'drug_type_id' => 'required',
        //         'status' => 'required|max:8'
        //     ];
        // }

        return [
            'drug_dose' => 'required',
            'drug_type_id' => 'required',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['drug_dose'] = $this->input('drug_dose');
        $inputData['drug_type_id'] = $this->input('drug_type_id');
        $inputData['status'] = $this->input('status');

        if ($this->input('drug_dose_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

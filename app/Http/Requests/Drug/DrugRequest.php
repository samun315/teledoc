<?php

namespace App\Http\Requests\Drug;

use Illuminate\Foundation\Http\FormRequest;

class DrugRequest extends FormRequest
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
            'trade_name' => 'required',
            'generic_name' => 'required',
            'note' => 'nullable',
            'warning' => 'nullable',
            'side_effect' => 'nullable',
            'additional_advice' => 'nullable',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['drug_id'] = $this->input('drug_id');
        $inputData['trade_name'] = $this->input('trade_name');
        $inputData['generic_name'] = $this->input('generic_name');
        $inputData['note'] = $this->input('note') ?? null;
        $inputData['warning'] = $this->input('warning') ?? null;
        $inputData['side_effect'] = $this->input('side_effect') ?? null;
        $inputData['additional_advice'] = $this->input('additional_advice') ?? null;
        $inputData['status'] = $this->input('status');

        if ($this->input('drug_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

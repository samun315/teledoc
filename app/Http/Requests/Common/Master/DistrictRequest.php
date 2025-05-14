<?php

namespace App\Http\Requests\Common\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DistrictRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        if ($this->input('district_id')) {
            return [
                'district_name' => [
                    'required', Rule::unique('districts')->ignore($this->input('district_id'), 'district_id')
                ],

                'division_id' => 'required',
                'short_code' =>'required',
                'active' => 'required|max:3'
            ];
        }

        return [
            'division_id' => 'required',
            'district_name' => 'required|unique:districts',
            'short_code' =>'required',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['division_id'] = $this->input('division_id');
        $inputData['district_name'] = $this->input('district_name');
        $inputData['short_code'] = strtoupper($this->input('short_code'));
        $inputData['active'] = $this->input('active');

        if ($this->has('district_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

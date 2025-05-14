<?php

namespace App\Http\Requests\Common\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpazilaRequest extends FormRequest
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
        if ($this->input('upazila_id')) {
            return [
                'upazila_name' => [
                    'required', Rule::unique('upazilas')->ignore($this->input('upazila_id'), 'upazila_id')
                ],

                'district_id' => 'required',
                'support_zone_id' =>'required',
                'active' => 'required|max:3'
            ];
        }

        return [
            'district_id' => 'required',
            'support_zone_id' =>'required',
            'upazila_name' => 'required|unique:upazilas',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['district_id'] = $this->input('district_id');
        $inputData['support_zone_id'] = $this->input('support_zone_id');
        $inputData['upazila_name'] = $this->input('upazila_name');
        $inputData['active'] = $this->input('active');

        if ($this->has('upazila_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

<?php

namespace App\Http\Requests\Common\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DivisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->input('division_id')) {
            return [
                'division_name' => [
                    'required', Rule::unique('divisions')->ignore($this->input('division_id'), 'division_id')
                ],

                'active' => 'required|max:3'
            ];
        }

        return [
            'division_name' => 'required|unique:divisions',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['division_name'] = $this->input('division_name');
        $inputData['active'] = $this->input('active');

        if ($this->has('division_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

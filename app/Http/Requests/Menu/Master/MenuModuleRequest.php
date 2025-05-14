<?php

namespace App\Http\Requests\Menu\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuModuleRequest extends FormRequest
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
        if ($this->input('module_id')) {
            return [
                'module_name' => [
                    'required', Rule::unique('menu_modules')->ignore($this->input('module_id'), 'module_id')
                ],

                'active' => 'required|max:3'
            ];
        }

        return [
            'module_name' => 'required|unique:menu_modules',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['module_name'] = $this->input('module_name');
        $inputData['active'] = $this->input('active');

        if ($this->has('module_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

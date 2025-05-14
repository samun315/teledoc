<?php

namespace App\Http\Requests\Menu\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class MenuRequest extends FormRequest
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
        if ($this->input('menu_id')) {
            return [
               'menu_name' => [
                    'required', Rule::unique('menus')->ignore($this->input('menu_id'), 'menu_id')
                ],
                'description' => 'nullable',
                'active' => 'required|max:3'
            ];
        }

        return [
            'menu_name' => 'required|unique:menus',
            'description' => 'nullable',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['menu_name'] = $this->input('menu_name');
        $inputData['description'] = $this->input('description');
        $inputData['active'] = $this->input('active');

        if ($this->input('menu_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

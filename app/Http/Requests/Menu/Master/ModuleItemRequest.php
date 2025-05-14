<?php

namespace App\Http\Requests\Menu\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ModuleItemRequest extends FormRequest
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
        if ($this->input('item_id')) {
            return [
               'item_name' => [
                    'required', Rule::unique('module_items')->ignore($this->input('item_id'), 'item_id')
                ],
                'module_id' => 'required',
                'active' => 'required|max:3'
            ];
        }

        return [
            'module_id' => 'required',
            'item_name' => 'required|unique:module_items',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['module_id'] = $this->input('module_id');
        $inputData['item_name'] = $this->input('item_name');
        $inputData['active'] = $this->input('active');

        if ($this->has('item_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

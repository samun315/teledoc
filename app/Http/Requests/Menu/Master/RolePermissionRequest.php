<?php

namespace App\Http\Requests\Menu\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolePermissionRequest extends FormRequest
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
        if ($this->input('role_permission_edit') == "EDIT") {
            return [
                'role_id' => 'required',
                'menu_permission_id' => 'nullable',
            ];
        }

        return [
            'role_id' => 'required|unique:menu_role_permissions',
            'menu_permission_id' => 'nullable',
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['role_id'] = $this->input('role_id');
        $inputData['menu_permission_id'] = $this->input('menu_permission_id');

        if ($this->has('menu_role_permission_id')) {

            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {

            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

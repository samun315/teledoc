<?php

namespace App\Http\Requests\Common\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRoleRequest extends FormRequest
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
        if ($this->input('role_id')) {
            return [
                'role_name' => [
                    'required', Rule::unique('user_roles')->ignore($this->input('role_id'), 'role_id')
                ],

                'active' => 'required|max:3'
            ];
        }

        return [
            'role_name' => 'required|unique:user_roles',
            'active' => 'required|max:3'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['role_name'] = $this->input('role_name');
        $inputData['active'] = $this->input('active');

        if ($this->has('role_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

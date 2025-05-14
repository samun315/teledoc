<?php

namespace App\Http\Requests\Menu\Master;

use Illuminate\Foundation\Http\FormRequest;


class PermissionRequest extends FormRequest
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
        if ($this->input('menu_permission_id')) {
            return [
                // 'menu_permission_id' => 'required',
                'item_id' => 'required',
                'name' => 'required',
                'slug' => 'required',

            ];
        }

        return [
            // 'menu_permission_id' => 'required',
            'item_id' => 'required',
            'name' => 'required',
            'slug' => 'required',


        ];
    }

    public function fields(): array
    {
        $inputData = [];

        // $inputData['menu_permission_id'] = $this->input('menu_permission_id');
        $inputData['item_id'] = $this->input('item_id');
        $inputData['name'] = $this->input('name');
        $inputData['slug'] = $this->input('slug');

        if ($this->has('menu_permission_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

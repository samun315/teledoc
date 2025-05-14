<?php

namespace App\Http\Requests\Menu\Menu;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuItemRequest extends FormRequest
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
        $validationData = [];
        //Basic Information

        $validationData['module_id'] = 'required';
        $validationData['type'] = 'required';

        if ($this->input('type') == 'divider') {
            $validationData['module_item_id'] = 'nullable';
            $validationData['parent_id'] = 'nullable';
            $validationData['menu_item_name'] = 'required';
            $validationData['url'] = 'nullable';
            $validationData['icon_class'] = 'nullable';
            $validationData['target'] = 'nullable';
            $validationData['active'] = 'nullable';
        } else if ($this->input('type') == 'parent') {
            $validationData['module_item_id'] = 'nullable';
            $validationData['parent_id'] = 'nullable';
            $validationData['menu_item_name'] = 'required';
            $validationData['url'] = 'nullable';
            $validationData['icon_class'] = 'nullable';
            $validationData['target'] = 'nullable';
            $validationData['active'] = 'required';
        } else {
            $validationData['module_item_id'] = 'required';
            $validationData['parent_id'] = 'nullable';
            $validationData['menu_item_name'] = 'required';
            $validationData['url'] = 'required';
            $validationData['icon_class'] = 'nullable';
            $validationData['target'] = 'nullable';
            $validationData['active'] = 'required';
        }

        return $validationData;
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['menu_id'] = $this->input('menu_id');
        $inputData['module_id'] = $this->input('module_id');
        $inputData['type'] = $this->input('type') === 'parent' ? 'menu_item' : $this->input('type');

        if ($this->input('type') == 'divider') {
            $inputData['module_item_id'] = null;
            $inputData['parent_id'] = null;
            $inputData['menu_item_name'] = $this->input('menu_item_name');
            $inputData['url'] = null;
            $inputData['icon_class'] = null;
            $inputData['target'] = null;
            $inputData['active'] = 'YES';
        } else if ($this->input('type') == 'parent') {
            $inputData['module_item_id'] = null;
            $inputData['parent_id'] = $this->input('parent_id') ?? null;
            $inputData['menu_item_name'] = $this->input('menu_item_name');
            $inputData['url'] = null;
            $inputData['icon_class'] = $this->input('icon_class') ?? null;
            $inputData['target'] = null;
            $inputData['active'] = $this->input('active');
        } else {
            $inputData['module_item_id'] = $this->input('module_item_id');
            $inputData['parent_id'] = $this->input('parent_id') ?? null;
            $inputData['menu_item_name'] = $this->input('menu_item_name');
            $inputData['url'] = $this->input('url');
            $inputData['icon_class'] = $this->input('icon_class');
            $inputData['target'] = $this->input('target');
            $inputData['active'] = $this->input('active');
        }

        if ($this->input('menu_item_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

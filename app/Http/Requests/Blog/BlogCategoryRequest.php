<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogCategoryRequest extends FormRequest
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
        if ($this->input('blog_category_id')) {
            return [
                'category_name' => [
                    'required',
                    Rule::unique('blog_categories')->ignore($this->input('blog_category_id'), 'blog_category_id')
                ],
                'description' => 'nullable|string|max:500',
                'status' => 'required|max:8'
            ];
        }

        return [
            'category_name' => 'required|unique:blog_categories',
            'description' => 'nullable|string|max:500',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['category_name'] = $this->input('category_name');
        $inputData['description'] = $this->input('description');
        $inputData['slug'] = Str::slug($this->input('category_name'));
        $inputData['status'] = $this->input('status');

        if ($this->input('blog_category_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class BlogTagRequest extends FormRequest
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
        if ($this->input('blog_tag_id')) {
            return [
                'tag_name' => [
                    'required',
                    Rule::unique('blog_tags')->ignore($this->input('blog_tag_id'), 'blog_tag_id')
                ],
                'description' => 'nullable|string|max:500',
                'status' => 'required|max:8'
            ];
        }

        return [
            'tag_name' => 'required|unique:blog_tags',
            'description' => 'nullable|string|max:500',
            'status' => 'required|max:8'
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['tag_name'] = $this->input('tag_name');
        $inputData['description'] = $this->input('description');
        $inputData['slug'] = Str::slug($this->input('tag_name'));
        $inputData['status'] = $this->input('status');

        if ($this->input('blog_tag_id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

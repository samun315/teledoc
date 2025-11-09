<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Draft,Published,Scheduled',
            'category_id' => 'required|exists:blog_categories,blog_category_id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,blog_tag_id',
            'meta_description' => 'nullable|string|max:160',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The blog title is required.',
            'title.max' => 'The blog title cannot exceed 100 characters.',
            'content.required' => 'The blog content is required.',
            'featured_image.image' => 'The featured image must be an image file.',
            'featured_image.mimes' => 'The featured image must be a JPEG, PNG, JPG, or GIF file.',
            'featured_image.max' => 'The featured image cannot exceed 2MB.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be either Draft, Published, or Scheduled.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
            'tags.*.exists' => 'One or more selected tags do not exist.',
            'meta_description.max' => 'The meta description cannot exceed 160 characters.',
        ];
    }
}

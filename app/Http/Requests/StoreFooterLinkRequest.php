<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFooterLinkRequest extends FormRequest
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
            'url' => 'required|string|max:255',
            'link_type' => 'required|in:internal,external',
            'section' => 'required|in:quick_links,services',
            'icon' => 'nullable|string|max:100',
            'target' => 'required|in:_self,_blank',
            'order' => 'nullable|integer|min:0',
            'active' => 'required|in:YES,NO',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'title' => 'title',
            'url' => 'URL/route',
            'link_type' => 'link type',
            'section' => 'section',
            'icon' => 'icon',
            'target' => 'target',
            'order' => 'order',
            'active' => 'status',
        ];
    }
}


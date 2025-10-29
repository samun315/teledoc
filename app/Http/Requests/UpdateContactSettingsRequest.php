<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactSettingsRequest extends FormRequest
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
            'contact_email_1' => 'required|email|max:255',
            'contact_email_2' => 'nullable|email|max:255',
            'contact_phone_1' => 'required|string|max:20',
            'contact_phone_2' => 'nullable|string|max:20',
            'contact_whatsapp' => 'nullable|string|max:20',
            'contact_address_1' => 'required|string|max:255',
            'contact_address_2' => 'nullable|string|max:255',
            'contact_city' => 'nullable|string|max:100',
            'contact_state' => 'nullable|string|max:100',
            'contact_postal_code' => 'nullable|string|max:20',
            'contact_country' => 'nullable|string|max:100',
        ];
    }

    /**
     * Get custom attribute names
     */
    public function attributes(): array
    {
        return [
            'contact_email_1' => 'primary email',
            'contact_email_2' => 'secondary email',
            'contact_phone_1' => 'primary phone',
            'contact_phone_2' => 'secondary phone',
            'contact_whatsapp' => 'WhatsApp number',
            'contact_address_1' => 'address line 1',
            'contact_address_2' => 'address line 2',
            'contact_city' => 'city',
            'contact_state' => 'state/province',
            'contact_postal_code' => 'postal code',
            'contact_country' => 'country',
        ];
    }
}


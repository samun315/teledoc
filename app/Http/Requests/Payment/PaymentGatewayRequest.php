<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentGatewayRequest extends FormRequest
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
        return [
            'gateway_name' => 'required',
            'details' => 'nullable',
            'currency_code' => 'required',
            'rate' => 'required',
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['gateway_name'] = $this->input('gateway_name') ?? null;
        $inputData['details'] = $this->input('details') ?? null;
        $inputData['currency_code'] = $this->input('currency_code') ?? null;
        $inputData['rate'] = $this->input('rate') ?? null;
        
        if ($this->input('id')) {
            $inputData['updated_by'] = loggedInUserId();
            $inputData['updated_at'] = createdAtDateConvertToDB();
        } else {
            $inputData['created_by'] = loggedInUserId();
            $inputData['created_at'] = createdAtDateConvertToDB();
        }

        return $inputData;
    }
}

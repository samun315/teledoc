<?php

namespace App\Http\Requests\Marchant;

use Illuminate\Foundation\Http\FormRequest;

class OrderBalanceRequest extends FormRequest
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
            'payment_gateway_id' => 'required',
            'amount' => 'required',
            'transaction_id' => 'required',
            'attachment_url' => 'required',
            'diamond_quantity' => 'nullable',
        ];
    }

    public function fields(): array
    {
        $inputData = [];

        $inputData['payment_gateway_id'] = $this->input('payment_gateway_id');
        $inputData['amount'] = $this->input('amount');
        $inputData['transaction_id'] = $this->input('transaction_id');
        $inputData['attachment_url'] = $this->input('attachment_url');
        $inputData['diamond_quantity'] = $this->input('diamond_quantity');

        $inputData['created_by'] = loggedInUserId();
        $inputData['created_at'] = createdAtDateConvertToDB();

        return $inputData;
    }
}

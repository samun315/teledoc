<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class BalanceAdjustRequest extends FormRequest
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
            'balance' => 'required',
            'type' => 'required',
            'user_id' => 'required',
        ];
    }


    public function fields(): array
    {
        $inputData = [];

        $inputData['balance'] = $this->input('balance');
        $inputData['type'] = $this->input('type');
        $inputData['user_id'] = $this->input('user_id');

        $inputData['created_by'] = loggedInUserId();
        $inputData['created_at'] = createdAtDateConvertToDB();

        return $inputData;
    }
}

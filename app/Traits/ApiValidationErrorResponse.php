<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiValidationErrorResponse
{
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'statusCode' => 422,
            'message' => 'Validation Error',
            'errors' => $validator->errors()
        ]));
    }
}

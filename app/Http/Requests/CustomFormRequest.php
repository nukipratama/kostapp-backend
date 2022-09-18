<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CustomFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $errors
            ], 400)
        );
    }
}

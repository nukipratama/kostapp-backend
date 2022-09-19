<?php

namespace App\Http\Requests;

class KostRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'location' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'],
            'is_available' => ['required', 'boolean'],
        ];
    }
}

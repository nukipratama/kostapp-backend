<?php

namespace App\Http\Requests;


class RegisterRequest extends CustomFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'min:8', 'max:255'],
            'password_confirmed' => ['required', 'same:password'],
        ];
    }
}

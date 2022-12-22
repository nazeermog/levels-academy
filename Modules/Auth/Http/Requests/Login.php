<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Login extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}

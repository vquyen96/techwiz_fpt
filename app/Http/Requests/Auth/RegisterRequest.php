<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:127',
            'email' => 'required|email|max:127|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }
}

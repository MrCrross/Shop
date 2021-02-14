<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function messages()
    {
        return [
            'name.required'         => 'Имя должно быть указано',
            'name.min'              => 'Минимальный размер имени - 3 символа',
            'name.max'              => 'Максимальный размер имени - 255 символов',
            'email.required'        => 'Почта должна быть указана',
            'email.email'           => 'Почта должно иметь вид mail@example.com',
            'email.unique'          => 'Почта уже занята',
            'password.required'     => 'Пароль должен быть указан',
            'password.min'          => 'Минимальный размер пароля - 8 символов',
            'password.confirmed'    => 'Пароли несовпадают'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|min:3|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:8|confirmed'
        ];
    }
}

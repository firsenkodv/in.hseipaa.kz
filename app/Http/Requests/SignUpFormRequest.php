<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignUpFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->guest();
    }


    public function rules(): array
    {
        return [
            'username' => ['required', 'string' , 'min:1'],
            'email' => ['required', 'email', 'email:dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];


    }

    protected function prepareForValidation():void
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value()
            ]
        );
    }
    public function messages(): array
    {
        return [
            'username.required' => 'Необходимо ввести имя.',
            'username.min' => 'Длина имени мин. :min.',
            'username.max' => 'Длина имени макс. :max.',
            'password.required' => 'Пароль обязателен.',
            'password.min' => 'Длина пароля мин. :min.',
            'password.max' => 'Длина пароля макс. :max.',
            'password.confirmed' => 'Введенные пароли не совпадают.',
            'email.required' => 'Email обязателен.',
            'email.min' => 'Длина email мин. :min.',
            'email.max' => 'Длина email макс. :max.',
        ];
    }
}

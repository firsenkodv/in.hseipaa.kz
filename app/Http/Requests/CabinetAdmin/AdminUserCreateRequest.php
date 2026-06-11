<?php

namespace App\Http\Requests\CabinetAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AdminUserCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('a');
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1'],
            'company'  => ['nullable', 'string', 'min:1', 'max:256'],
            'email'    => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => str(request('email'))->squish()->lower()->value()
        ]);
    }

    public function messages(): array
    {
        return [
            'username.required'  => 'Необходимо ввести имя.',
            'username.min'       => 'Длина имени мин. :min.',
            'email.required'     => 'Email обязателен.',
            'email.email'        => 'Введите корректный Email.',
            'email.unique'       => 'Пользователь с таким Email уже существует.',
            'password.required'  => 'Пароль обязателен.',
            'password.confirmed' => 'Введённые пароли не совпадают.',
            'password.min'       => 'Длина пароля мин. :min.',
            'company.min'        => 'Длина названия мин. :min.',
            'company.max'        => 'Длина названия макс. :max.',
        ];
    }
}

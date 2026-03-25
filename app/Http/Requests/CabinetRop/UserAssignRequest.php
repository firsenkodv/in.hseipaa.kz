<?php

namespace App\Http\Requests\CabinetRop;

use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Foundation\Http\FormRequest;

class UserAssignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool)ROPViewModel::make()->r(session()->get('r'));
    }

    public function rules(): array
    {
        return [
            'id'      => ['required', 'integer', 'exists:managers,id'],
            'users'   => ['required', 'array', 'min:1'],
            'users.*' => ['integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'    => 'Не выбран менеджер.',
            'id.exists'      => 'Менеджер не найден.',
            'users.required' => 'Не выбраны пользователи.',
            'users.min'      => 'Выберите хотя бы одного пользователя.',
            'users.*.exists' => 'Один из пользователей не найден.',
        ];
    }
}

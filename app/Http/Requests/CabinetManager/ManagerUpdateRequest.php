<?php

namespace App\Http\Requests\CabinetManager;

use Domain\Manager\ViewModels\ManagerViewModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManagerUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return (bool)ManagerViewModel::make()->m(session()->get('m'));
    }


    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'email:dns',
                Rule::unique('managers')->ignore(ManagerViewModel::make()->m(session()->get('m'))->id, 'id')],

            'phone' => ['nullable', 'string', 'min:5'],

        ];


    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value(),
                'phone' => phone($this->phone),
                          ]
        );
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Необходимо ввести имя.',
            'username.min' => 'Длина имени мин. :min.',
            'username.max' => 'Длина имени макс. :max.',
            'email.required' => 'Email обязателен.',
            'email.unique' => 'Email уже используется в системе.',
            'phone.min' => 'Длина номера телефона недостаточная.',
        ];
    }
}

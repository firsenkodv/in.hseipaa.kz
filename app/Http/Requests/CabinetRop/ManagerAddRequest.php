<?php

namespace App\Http\Requests\CabinetRop;

use Illuminate\Validation\Rule;

class ManagerAddRequest extends ManagerUpdateRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email',
                Rule::unique('managers')],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'min:5'],
            'telegram' => ['nullable', 'string', 'min:2', 'max:256'],
            'whatsapp' => ['nullable', 'string', 'min:5', 'max:256'],
            'instagram' => ['nullable', 'string', 'min:3', 'max:256'],

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
                'iin' => str(request('iin'))->squish()->lower()->value(),
                'bin' => str(request('bin'))->squish()->lower()->value(),
                'telegram' => str(request('telegram'))->squish()->lower()->value(),
                'whatsapp' => str(request('whatsapp'))->squish()->lower()->value(),
                'instagram' => str(request('instagram'))->squish()->lower()->value(),

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
            'telegram.min' => 'Длина telegram мин. :min.',
            'telegram.max' => 'Длина telegram макс. :max.',
            'whatsapp.min' => 'Длина whatsapp мин. :min.',
            'whatsapp.max' => 'Длина whatsapp макс. :max.',
            'instagram.min' => 'Длина instagram мин. :min.',
            'instagram.max' => 'Длина instagram макс. :max.',


        ];
    }


}

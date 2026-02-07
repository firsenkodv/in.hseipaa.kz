<?php

namespace App\Http\Requests\CabinetRop;

use App\Rules\ValidUrl;
use Carbon\Carbon;
use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RopUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return (bool)ROPViewModel::make()->r(session()->get('r'));
    }


    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'email:dns',
                Rule::unique('r_o_p_s')->ignore(ROPViewModel::make()->r(session()->get('r'))->id, 'id')],

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

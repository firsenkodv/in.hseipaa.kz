<?php

namespace App\Http\Requests\CabinetAdmin;

use Domain\Admin\ViewModels\AdminViewModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) AdminViewModel::make()->a(session()->get('a'));
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email'    => [
                'required', 'email', 'email:dns',
                Rule::unique('admins')->ignore(AdminViewModel::make()->a(session()->get('a'))->id, 'id'),
            ],
            'phone' => ['nullable', 'string', 'min:5'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => str(request('email'))->squish()->lower()->value(),
            'phone' => phone($this->phone),
        ]);
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Необходимо ввести имя.',
            'username.min'      => 'Длина имени мин. :min.',
            'username.max'      => 'Длина имени макс. :max.',
            'email.required'    => 'Email обязателен.',
            'email.unique'      => 'Email уже используется в системе.',
            'phone.min'         => 'Длина номера телефона недостаточная.',
        ];
    }
}

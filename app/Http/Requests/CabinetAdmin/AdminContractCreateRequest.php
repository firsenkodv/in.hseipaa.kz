<?php

namespace App\Http\Requests\CabinetAdmin;

use Illuminate\Foundation\Http\FormRequest;

class AdminContractCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('a');
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'training_id' => trim(str_replace('*', '', $this->input('training_id'))),
            'currency'    => trim(str_replace('*', '', $this->input('currency'))),
            'price'       => str_replace(' ', '', $this->input('price')),
        ]);
    }

    public function rules(): array
    {
        return [
            'user_id'      => ['required', 'integer', 'exists:users,id'],
            'fio'          => ['required', 'string'],
            'email'        => ['required', 'email'],
            'phone'        => ['required', 'string'],
            'training_id'  => ['required', 'string'],
            'organization' => ['required', 'string'],
            'date_from'    => ['required', 'string'],
            'date_to'      => ['required', 'string'],
            'price'        => ['required', 'numeric'],
            'currency'     => ['required', 'string'],
            'hours'        => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'fio.required'          => 'Введите ФИО.',
            'email.required'        => 'Email обязателен.',
            'email.email'           => 'Введите корректный Email.',
            'phone.required'        => 'Телефон обязателен.',
            'training_id.required'  => 'Выберите дисциплину.',
            'organization.required' => 'Выберите организацию обучения.',
            'organization.in'       => 'Выбрана недопустимая организация.',
            'date_from.required'    => 'Укажите дату начала.',
            'date_to.required'      => 'Укажите дату окончания.',
            'price.required'        => 'Укажите стоимость.',
            'price.numeric'         => 'Стоимость должна быть числом.',
            'currency.required'     => 'Выберите валюту.',
            'hours.required'        => 'Укажите количество часов.',
            'hours.integer'         => 'Количество часов должно быть целым числом.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCallMeBlueRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'ФИО' => ['required', 'string', 'min:2','max:100'],
            'Телефон' => ['required', 'string' , 'min:6','max:100'],
            'Email' => ['required', 'string' , 'min:4', 'max:100'],
        ];

    }

    protected function prepareForValidation()
    {

    }

    /**
     * Метод для замены стандартных сообщений об ошибках
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'ФИО.required' => 'Необходимо ввести ФИО.',
            'ФИО.min' => 'Длина имени мин. :min.',
            'ФИО.max' => 'Длина имени макс. :max.',
            'Телефон.required' => 'Необходим номер телефона.',
            'Телефон.min' => 'Длина телефона мин. :min.',
            'Телефон.max' => 'Длина телефона макс. :max.',
            'Email.required' => 'Email обязателен.',
            'Email.min' => 'Длина email мин. :min.',
            'Email.max' => 'Длина email макс. :max.',
        ];
    }
}

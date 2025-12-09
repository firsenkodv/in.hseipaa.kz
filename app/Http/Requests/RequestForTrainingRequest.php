<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestForTrainingRequest extends FormRequest
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
            config2('moonshine.setting.f1_label') => ['required', 'string', 'min:4', 'max:100'],
            config2('moonshine.setting.f2_label') => ['required', 'string', 'min:4', 'max:100'],

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
            'ФИО.min' => 'Минимальная длина имени пользователя должна составлять :min символов.',
            'ФИО.max' => 'Максимальная длина имени пользователя не должна превышать :max символов.',
            'Телефон.required' => 'Необходимо ввести номер телефона.',
            'Телефон.min' => 'Минимальная длина номера телефона должна составлять :min символов.',
            'Телефон.max' => 'Максимальная длина номера телефона не должна превышать :max символов.',
            'Email.required' => 'Электронная почта обязательна для заполнения.',
            'Email.min' => 'Минимальная длина адреса электронной почты должна составлять :min символов.',
            'Email.max' => 'Максимальная длина адреса электронной почты не должна превышать :max символов.',
            config2('moonshine.setting.f1_label').'.required' => 'Поле обязательно для заполнения.',
            config2('moonshine.setting.f1_label').'.min' => 'Минимальная длина  должна составлять :min символов.',
            config2('moonshine.setting.f1_label').'.max' => 'Максимальная длина не должна превышать :max символов.',
            config2('moonshine.setting.f2_label').'.required' => 'Поле обязательно для заполнения.',
            config2('moonshine.setting.f2_label').'.min' => 'Минимальная длина  должна составлять :min символов.',
            config2('moonshine.setting.f2_label').'.max' => 'Максимальная длина не должна превышать :max символов.',
        ];
    }

}

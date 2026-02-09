<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AvatarRequest extends FormRequest
{

    public function authorize(): bool
    {

        return true; //auth()->user()->id;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['required', 'mimes:jpg,jpeg,png,gif,webp,avif', 'max:9048'], // Размер максимум 9MB
        ];

    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Необходимо загрузить аватар.',
            'avatar.max' => 'Очень большой файл, более 9Mb ...',
            'avatar.mimes' => 'Ошибка в типе файла.',

        ];
    }
}

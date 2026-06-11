<?php

namespace App\Http\Requests\CabinetAdmin;

use Illuminate\Foundation\Http\FormRequest;

class AdminTrainingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return session()->has('a');
    }

    public function rules(): array
    {
        return [
            'training_id' => ['required', 'integer', 'exists:trainings,id'],
            'title'       => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Введите название дисциплины.',
            'title.max'      => 'Название не должно превышать 255 символов.',
        ];
    }
}

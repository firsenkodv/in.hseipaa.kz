<?php

namespace App\Http\Requests\HH\Resume;

use Illuminate\Foundation\Http\FormRequest;

class StoreResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title'               => ['required', 'string', 'max:255'],
            'subtitle'            => ['nullable', 'string', 'max:255'],
            'post'                => ['nullable', 'string', 'max:255'],
            'hunter_category_id'  => ['required', 'integer', 'exists:hunter_categories,id'],
            'user_city_id'        => ['nullable', 'integer', 'exists:user_cities,id'],
            'hunter_experience_id'=> ['nullable', 'integer', 'exists:hunter_experiences,id'],
            'price'               => ['nullable', 'integer', 'min:0'],
            'desc'                => ['nullable', 'string'],
            'must'                => ['nullable', 'string'],
            'conditions'          => ['nullable', 'string'],
            'address'             => ['nullable', 'string', 'max:500'],
            'email'               => ['nullable', 'email'],
            'phone'               => ['nullable', 'string', 'max:50'],
            'telegram'            => ['nullable', 'string', 'max:255'],
            'whatsapp'            => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price' => $this->price
                ? (int) str_replace(' ', '', $this->price)
                : null,
            'phone' => $this->phone
                ? phone($this->phone)
                : null,
        ]);
    }

    public function messages(): array
    {
        return [
            'title.required'              => 'Название резюме обязательно.',
            'title.max'                   => 'Название резюме не более :max символов.',
            'hunter_category_id.required' => 'Выберите категорию.',
            'hunter_category_id.exists'   => 'Выбранная категория не найдена.',
            'user_city_id.exists'         => 'Выбранный город не найден.',
            'hunter_experience_id.exists' => 'Выбранный опыт работы не найден.',
            'price.integer'               => 'Зарплата должна быть числом.',
            'price.min'                   => 'Зарплата не может быть отрицательной.',
            'email.email'                 => 'Некорректный email.',
        ];
    }
}

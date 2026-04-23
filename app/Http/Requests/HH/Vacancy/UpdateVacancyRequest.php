<?php

namespace App\Http\Requests\HH\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVacancyRequest extends FormRequest
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
            'company'             => ['nullable', 'string', 'max:255'],
            'logo'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:6048'],
            'desc'                => ['nullable', 'string'],
            'must'                => ['nullable', 'string'],
            'conditions'          => ['nullable', 'string'],
            'address'             => ['nullable', 'string', 'max:500'],
            'email'               => ['nullable', 'email'],
            'phone'               => ['nullable', 'string', 'max:50'],
            'telegram'            => ['nullable', 'string', 'max:255'],
            'whatsapp'            => ['nullable', 'string', 'max:255'],
            'remove_logo'         => ['nullable', 'in:0,1'],
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
            'title.required'              => 'Название вакансии обязательно.',
            'title.max'                   => 'Название вакансии не более :max символов.',
            'hunter_category_id.required' => 'Выберите категорию.',
            'hunter_category_id.exists'   => 'Выбранная категория не найдена.',
            'user_city_id.exists'         => 'Выбранный город не найден.',
            'hunter_experience_id.exists' => 'Выбранный опыт работы не найден.',
            'price.integer'               => 'Зарплата должна быть числом.',
            'price.min'                   => 'Зарплата не может быть отрицательной.',
            'logo.image'                  => 'Логотип должен быть изображением.',
            'logo.mimes'                  => 'Допустимые форматы: jpg, jpeg, png, webp.',
            'logo.max'                    => 'Размер логотипа не более 6 МБ.',
            'email.email'                 => 'Некорректный email.',
        ];
    }
}

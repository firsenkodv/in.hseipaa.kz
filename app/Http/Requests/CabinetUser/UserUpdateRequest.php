<?php

namespace App\Http\Requests\CabinetUser;


use Domain\Manager\ViewModels\ManagerViewModel;
use Domain\ROP\ViewModels\ROPViewModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        if (auth()->check()) {
            return true;
        }
        if(ROPViewModel::make()->r(session()->get('r'))) {
            return true;
        }
        if(ManagerViewModel::make()->m(session()->get('m'))) {
            return true;
        }

        return false;

    }

    public function rules(): array
    {
        $rules = [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'email:dns',
                Rule::unique('users')->ignore($this->input('id'), 'id')],

            'phone' => ['nullable', 'string', 'min:5'],
            'iin' => ['nullable', 'string', 'min:3'],
            'bin' => ['nullable', 'string', 'min:3'],
            'address.json_address_post_index' => ['nullable', 'string', 'min:3', 'max:20'],
            'address.json_address_area' => ['nullable', 'string', 'min:3', 'max:500'],
            'address.json_address_street' => ['nullable', 'string', 'max:256'],
            'address.json_address_house' => ['nullable', 'string', 'max:256'],
            'address.json_address_office' => ['nullable', 'string', 'max:256'],
            'accountant_ticket' => ['nullable', 'string', 'max:256'],
            'telegram' => ['nullable', 'string', 'min:2', 'max:256'],
            'whatsapp' => ['nullable', 'string', 'min:5', 'max:256'],
            'instagram' => ['nullable', 'string', 'min:3', 'max:256'],
            'website' => ['nullable', 'string', 'min:3', 'max:256', new   \App\Rules\ValidUrl],
            'about_me' => ['nullable', 'string', 'min:3', 'max:1000'],
            'date_birthday' => ['date_format:d.m.Y', 'nullable'],
            'accountant_ticket_date' => ['date_format:d.m.Y', 'nullable'],
        ];

        foreach ($this->input('specialists', []) as $id) {
            $rules["specialist_certificate_number.{$id}"] = ['required', 'string', 'max:255'];
            $rules["specialist_certificate_date.{$id}"] = ['required', 'date_format:d.m.Y'];
        }

        foreach ($this->input('qualifications', []) as $id) {
            $rules["qualification_custom_documents.{$id}"] = ['nullable', 'string', 'max:255'];
            $rules["qualification_certificate_date.{$id}"]  = ['nullable', 'date_format:d.m.Y'];
        }

        return $rules;
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
                'accountant_ticket' => trim($this->accountant_ticket),
                'telegram' => str(request('telegram'))->squish()->lower()->value(),
                'whatsapp' => str(request('whatsapp'))->squish()->lower()->value(),
                'instagram' => str(request('instagram'))->squish()->lower()->value(),
                'about_me' => str(request('about_me'))->stripTags('<br></ br><ul><li>')->value(),
                'experience' => str(request('experience'))->stripTags('<br></ br><ul><li>')->value(),
             /*   'website' => str(request('website'))->squish()->lower()->value(),*/


            ]
        );
    }

    public function messages(): array
    {
        $messages = [
            'username.required' => 'Необходимо ввести имя.',
            'username.min' => 'Длина имени мин. :min.',
            'username.max' => 'Длина имени макс. :max.',
            'email.required' => 'Email обязателен.',
            'email.unique' => 'Email уже используется в системе.',
            'phone.min' => 'Длина номера телефона недостаточная.',
            'iin.min' => 'Длина ИИН мин. :min.',
            'bin.min' => 'Длина ИИН мин. :min.',
            'address.json_address_post_index.min' => 'Длина для индекса не достаточна.',
            'address.json_address_post_index.max' => 'Длина для индекса слишком велика.',
            'address.json_address_area.max' => 'Длина для области слишком велика.',
            'address.json_address_street.max' => 'Длина для улицы слишком велика.',
            'address.json_address_house.max' => 'Длина для номера дома слишком велика.',
            'address.json_address_office.max' => 'Длина для улицы или офиса дома слишком велика.',
            'accountant_ticket' => 'Длина номера макс. :max.',
            'telegram.min' => 'Длина telegram мин. :min.',
            'telegram.max' => 'Длина telegram макс. :max.',
            'whatsapp.min' => 'Длина whatsapp мин. :min.',
            'whatsapp.max' => 'Длина whatsapp макс. :max.',
            'instagram.min' => 'Длина instagram мин. :min.',
            'instagram.max' => 'Длина instagram макс. :max.',
            'website.min' => 'Длина website мин. :min.',
            'website.max' => 'Длина website макс. :max.',
            'website.ValidUrl' => '!Описано в классе!',
            'about_me.min' => 'Длина описания минимум :min.',
            'about_me.max' => 'Длина описания макс. :max.',
            'experience.min' => 'Длина описания минимум :min.',
            'experience.max' => 'Длина описания макс. :max.',
            'date_birthday.date_format' => 'Не правильный формат даты.',
            'accountant_ticket_date.date_format' => 'Не правильный формат даты.',
        ];

        foreach ($this->input('specialists', []) as $id) {
            $messages["specialist_certificate_number.{$id}.required"]  = 'Укажите номер сертификата.';
            $messages["specialist_certificate_number.{$id}.max"]       = 'Номер сертификата слишком длинный.';
            $messages["specialist_certificate_date.{$id}.required"]    = 'Укажите дату выдачи сертификата.';
            $messages["specialist_certificate_date.{$id}.date_format"] = 'Неправильный формат даты сертификата.';
        }

        foreach ($this->input('qualifications', []) as $id) {
            $messages["qualification_certificate_date.{$id}.date_format"] = 'Неправильный формат даты сертификата.';
        }

        return $messages;
    }
}

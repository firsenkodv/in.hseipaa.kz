<?php

namespace App\Http\Requests\CabinetUser;

use App\Rules\ValidUrl;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->user()->id;
    }


    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'email:dns',
                Rule::unique('users')->ignore(auth()->id(), 'id')],

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
                // Конвертируем дату в нужный формат
                'date_birthday' => ($this->input('date_birthday')) ? Carbon::createFromFormat('d.m.Y', $this->input('date_birthday'))->format('Y-m-d') : null,
                // Конвертируем дату в нужный формат
                'accountant_ticket_date' => ($this->input('accountant_ticket_date')) ? Carbon::createFromFormat('d.m.Y', $this->input('accountant_ticket_date'))->format('Y-m-d') : null,
                'iin' => str(request('iin'))->squish()->lower()->value(),
                'bin' => str(request('bin'))->squish()->lower()->value(),
                'accountant_ticket' => trim($this->accountant_ticket),
                'telegram' => str(request('telegram'))->squish()->lower()->value(),
                'whatsapp' => str(request('whatsapp'))->squish()->lower()->value(),
                'instagram' => str(request('instagram'))->squish()->lower()->value(),
                'about_me' => str(request('about_me'))->stripTags('<br></br></ br><ul><li>')->value(),
                'experience' => str(request('experience'))->stripTags('<br></br></ br><ul><li>')->value(),
             /*   'website' => str(request('website'))->squish()->lower()->value(),*/


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

        ];
    }
}

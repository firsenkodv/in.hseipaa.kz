<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SignInFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return auth()->guest();
    }


    public function rules(): array
    {
        return [
            'email' => ['required'],
            'password' => ['required'],
        ];
    }

    protected function prepareForValidation():void
    {
        $this->merge(
            [
                'email' => str(request('email'))
                    ->squish()
                    ->lower()
                    ->value()
            ]
        );
    }
    public function messages(): array
    {
        return [

        ];
    }
}

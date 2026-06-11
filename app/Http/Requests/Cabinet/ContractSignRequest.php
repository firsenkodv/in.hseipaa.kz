<?php

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractSignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'contract_id' => [
                'required',
                'integer',
                Rule::exists('contracts', 'id')
                    ->where('user_id', auth()->id())
                    ->where('is_signed', false),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'contract_id.exists' => 'Договор не найден или уже подписан.',
        ];
    }
}

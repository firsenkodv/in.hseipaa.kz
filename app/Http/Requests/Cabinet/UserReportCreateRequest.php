<?php

namespace App\Http\Requests\Cabinet;

use Illuminate\Foundation\Http\FormRequest;

class UserReportCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'report_period_from' => ['required', 'string'],
            'report_period_to'   => ['required', 'string'],
            'report_type'        => ['required', 'string', 'max:500'],
            'discipline_name'    => ['required', 'string', 'max:500'],
            'school_name'        => ['required', 'string', 'max:500'],
            'certificates'       => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'report_period_from.required' => 'Укажите начало периода отчёта.',
            'report_period_to.required'   => 'Укажите конец периода отчёта.',
            'report_type.required'        => 'Укажите вид отчёта.',
            'discipline_name.required'    => 'Укажите наименование дисциплины.',
            'school_name.required'        => 'Укажите наименование учебного заведения.',
        ];
    }
}

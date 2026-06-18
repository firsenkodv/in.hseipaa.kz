<?php

namespace App\Http\Requests\CabinetManager;

use Illuminate\Foundation\Http\FormRequest;

class ManagerReportUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_id'          => 'required|integer',
            'report_period_from' => 'required|string',
            'report_period_to'   => 'required|string',
            'report_type'        => 'required|string|max:255',
            'discipline_name'    => 'required|string|max:255',
            'school_name'        => 'required|string|max:255',
        ];
    }
}

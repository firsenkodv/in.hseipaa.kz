<?php

namespace App\Http\Requests\CabinetManager;

use Illuminate\Foundation\Http\FormRequest;

class ManagerReportAcceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'report_id' => 'required|integer',
        ];
    }
}

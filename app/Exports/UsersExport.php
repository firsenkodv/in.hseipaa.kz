<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function __construct(private readonly array $data) {}

    public function headings(): array
    {
        return [
            'ID',
            'ФИО / Компания',
            'Email',
            'Телефон',
            'ИИН / БИН',
            'Город',
            'Тип',
            'Специалист',
            'Эксперт',
            'Лектор',
            'Квалификации',
            'Дата регистрации',
        ];
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE8F0F8'],
                ],
            ],
        ];
    }
}

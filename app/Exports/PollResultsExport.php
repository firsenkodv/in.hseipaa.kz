<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PollResultsExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function __construct(
        private readonly array $headings,
        private readonly array $data,
        private readonly string $pollTitle,
    ) {}

    public function headings(): array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet): array
    {
        $lastCol = $sheet->getHighestColumn();

        // Заголовок опроса в первой строке
        $sheet->insertNewRowBefore(1);
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->setCellValue('A1', $this->pollTitle);
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill'      => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF095C9A'],
            ],
            'font' => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FFFFFFFF']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Шапка таблицы (теперь строка 2)
        return [
            2 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE8F0F8'],
                ],
            ],
        ];
    }
}

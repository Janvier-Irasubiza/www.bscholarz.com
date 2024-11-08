<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RevenueExport implements FromCollection, WithHeadings, WithStyles
{
    protected $revenueData;

    public function __construct($revenueData)
    {
        $this->revenueData = $revenueData;
    }

    public function collection()
    {
        return collect($this->revenueData)->map(function($data) {
            return [
                'Applicant' => $data->names,
                'Application' => $data->discipline_name,
                'Assistant' => $data->assistant_names,
                'Served on' => $data->served_on,
                'Amount Paid' => $data->amount_paid,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Applicant',
            'Application',
            'Assistant',
            'Served on',
            'Amount Paid',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerRow = 1; // Assuming your headers are in the first row
        $lastColumn = 'E'; // Adjust according to your last header column

        // Apply style to the header row
        $sheet->getStyle("A{$headerRow}:{$lastColumn}{$headerRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'argb' => Color::COLOR_BLACK,
                ],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => Color::COLOR_BLACK],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFDDDDDD'], // Header background color
            ],
        ]);
    }
}

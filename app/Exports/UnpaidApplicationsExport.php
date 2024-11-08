<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class UnpaidApplicationsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $unpaidApplications;

    public function __construct($unpaidApplications)
    {
        $this->unpaidApplications = $unpaidApplications;
    }

    public function collection()
    {
        return collect($this->unpaidApplications)->map(function($application) {
            return [
                'Debtor Name' => $application->names,
                'Email' => $application->email,
                'Phone Number' => $application->phone_number,
                'Service Name' => $application->discipline_name,
                'Organization' => $application->discipline_organization,
                'Outstanding Amount' => $application->outstanding_amount,
                'Owes To' => $application->assistant_names,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Debtor Name',
            'Email',
            'Phone Number',
            'Service Name',
            'Organization',
            'Outstanding Amount',
            'Owes To',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $headerRow = 1; // Assuming your headers are in the first row
        $lastColumn = 'G'; // Updated to 'G' to include the new header column

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

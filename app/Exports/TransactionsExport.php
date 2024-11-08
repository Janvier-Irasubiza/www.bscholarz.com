<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithStyles
{
    protected $transactions;
    protected $sortBy;
    protected $employeeName; // Store employee name instead of ID
    protected $applicationName; // Store application name instead of ID
    protected $startDate;
    protected $endDate;

    public function __construct($transactions, $sortBy = null, $employeeName = null, $applicationName = null, $startDate = null, $endDate = null)
    {
        $this->transactions = $transactions;
        $this->sortBy = $sortBy; // Capture sortBy
        $this->employeeName = $employeeName; // Capture employee name
        $this->applicationName = $applicationName; // Capture application name
        $this->startDate = $startDate; // Capture start date
        $this->endDate = $endDate; // Capture end date
    }

    public function collection()
    {
        // Create an array for the header rows (sorting conditions)
        $data = [];

        // Prepare sorting condition string
        $sortingCondition = "Sorted by: ";
        $conditions = [];

        // Add sorting conditions based on provided values
        if ($this->sortBy) {
            $conditions[] = ucfirst($this->sortBy); // Capitalize sortBy value
        }
        if ($this->employeeName) {
            $conditions[] = "Employee: {$this->employeeName}"; // Include employee name
        }
        if ($this->applicationName) {
            $conditions[] = "Application: {$this->applicationName}"; // Include application name
        }
        if ($this->startDate && $this->endDate) {
            $conditions[] = "Date Range: {$this->startDate} to {$this->endDate}"; // Include date range
        }

        // Combine all conditions into a single string
        if (!empty($conditions)) {
            $sortingCondition .= implode(', ', $conditions); // Join conditions with commas
            $data[] = [$sortingCondition]; // Add sorting condition as the first row
        }

        // Add a blank row for separation
        $data[] = ['']; // Blank row

        // Prepare the actual data headers
        $data[] = [
            'Transaction ID',
            'Amount Paid (RWF)',
            'Payment Date',
            'Assistant',
        ];

        // Map through transactions and add to data
        foreach ($this->transactions as $transaction) {
            $data[] = [
                $transaction->payment_id,
                number_format($transaction->amount_paid, 2),
                \Carbon\Carbon::parse($transaction->served_on)->format('d-m-Y'),
                $transaction->assistant_names,
            ];
        }

        return collect($data);
    }

    public function headings(): array
    {
        // Return an empty array since the headers are now included in the data itself
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        // Define styles for bold and centered text
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        // Apply styles to the sorting condition row (first row)
        if ($this->sortBy || $this->employeeName || $this->applicationName || ($this->startDate && $this->endDate)) {
            $sheet->getStyle("A1:D1")->applyFromArray($styleArray);
            // Apply styles to the second row (blank)
            $sheet->getStyle("A2:D2")->applyFromArray($styleArray);
        }

        // Apply styles to the headers row (row 3)
        $sheet->getStyle("A3:D3")->applyFromArray($styleArray);

        return [];
    }
}

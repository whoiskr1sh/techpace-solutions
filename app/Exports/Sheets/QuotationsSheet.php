<?php

namespace App\Exports\Sheets;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuotationsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return Quotation::query();
    }

    public function title(): string
    {
        return 'Quotations';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Quotation Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Total Amount',
            'Currency', // Added
            'Status',
            'Created By (User ID)',
            'Created At',
        ];
    }

    public function map($quotation): array
    {
        return [
            $quotation->id,
            $quotation->quotation_number,
            $quotation->customer_name,
            $quotation->customer_email,
            $quotation->customer_phone,
            $quotation->total_amount,
            $quotation->currency, // Added
            $quotation->status,
            $quotation->created_by,
            $quotation->created_at,
        ];
    }
}

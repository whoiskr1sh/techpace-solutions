<?php

namespace App\Exports\Sheets;

use App\Models\SalesOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesOrdersSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return SalesOrder::query();
    }

    public function title(): string
    {
        return 'Sales Orders';
    }

    public function headings(): array
    {
        return [
            'ID',
            'SO Number',
            'Quotation ID',
            'Total Amount',
            'Status',
            'Created By (User ID)',
            'Created At',
        ];
    }

    public function map($so): array
    {
        return [
            $so->id,
            $so->so_number,
            $so->quotation_id,
            $so->total_amount,
            $so->status,
            $so->created_by,
            $so->created_at,
        ];
    }
}

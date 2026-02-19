<?php

namespace App\Exports\Sheets;

use App\Models\ProformaInvoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProformaInvoicesSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return ProformaInvoice::query();
    }

    public function title(): string
    {
        return 'Proforma Invoices';
    }

    public function headings(): array
    {
        return [
            'ID',
            'PI Number',
            'Sales Order ID',
            'Customer Name',
            'Issue Date',
            'Total Amount',
            'Status',
            'Created By (User ID)',
            'Created At',
        ];
    }

    public function map($pi): array
    {
        return [
            $pi->id,
            $pi->pi_number,
            $pi->sales_order_id,
            $pi->customer_name,
            $pi->issue_date,
            $pi->total_amount,
            $pi->status,
            $pi->created_by,
            $pi->created_at,
        ];
    }
}

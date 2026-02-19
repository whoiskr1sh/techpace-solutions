<?php

namespace App\Exports\Sheets;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InvoicesSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return Invoice::query();
    }

    public function title(): string
    {
        return 'Invoices';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Invoice Number',
            'Proforma Invoice ID',
            'Sales Order ID',
            'Customer Name',
            'Issue Date',
            'Due Date',
            'Total Amount',
            'Status',
            'Created By (User ID)',
            'Created At',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->invoice_number,
            $invoice->proforma_invoice_id,
            $invoice->sales_order_id,
            $invoice->customer_name,
            $invoice->issue_date,
            $invoice->due_date,
            $invoice->total_amount,
            $invoice->status,
            $invoice->created_by,
            $invoice->created_at,
        ];
    }
}

<?php

namespace App\Exports\Sheets;

use App\Models\Courier;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CouriersSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return Courier::query()->with(['invoice', 'salesOrder', 'creator']);
    }

    public function title(): string
    {
        return 'Couriers';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date',
            'Type',
            'Courier Name',
            'Tracking Number',
            'Recipient Name',
            'Invoice Number',
            'Sales Order Number',
            'Status',
            'Shipped At',
            'Delivered At',
            'Remarks',
            'Created By',
            'Created At',
            'Updated At',
        ];
    }

    public function map($courier): array
    {
        return [
            $courier->id,
            $courier->date,
            $courier->type,
            $courier->courier_name,
            $courier->tracking_number,
            $courier->recipient_name,
            $courier->invoice ? $courier->invoice->invoice_number : '',
            $courier->salesOrder ? $courier->salesOrder->so_number : '',
            $courier->status,
            $courier->shipped_at,
            $courier->delivered_at,
            $courier->remarks,
            $courier->creator ? $courier->creator->name : '',
            $courier->created_at,
            $courier->updated_at,
        ];
    }
}

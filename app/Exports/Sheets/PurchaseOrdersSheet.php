<?php

namespace App\Exports\Sheets;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchaseOrdersSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return PurchaseOrder::query();
    }

    public function title(): string
    {
        return 'Purchase Orders';
    }

    public function headings(): array
    {
        return [
            'ID',
            'PO Number',
            'Vendor ID',
            'Sales Order ID',
            'Order Date',
            'Expected Date',
            'Total Amount',
            'Status',
            'Created By (User ID)',
            'Created At',
        ];
    }

    public function map($po): array
    {
        return [
            $po->id,
            $po->po_number,
            $po->vendor_id,
            $po->sales_order_id,
            $po->order_date,
            $po->expected_date,
            $po->total_amount,
            $po->status,
            $po->created_by,
            $po->created_at,
        ];
    }
}

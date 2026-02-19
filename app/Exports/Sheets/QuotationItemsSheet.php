<?php

namespace App\Exports\Sheets;

use App\Models\QuotationItem;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class QuotationItemsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return QuotationItem::query()->with('quotation');
    }

    public function title(): string
    {
        return 'Quotation Items';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Quotation Number',
            'Make',
            'Model No',
            'Unit Price',
            'Discount',
            'Unit Discounted Price',
            'Quantity',
            'Total Price',
            'Delivery Time',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->quotation ? $item->quotation->quotation_number : '',
            $item->make,
            $item->model_no,
            $item->unit_price,
            $item->discount,
            $item->unit_discounted_price,
            $item->quantity,
            $item->total_price,
            $item->delivery_time,
            $item->remarks,
            $item->created_at,
            $item->updated_at,
        ];
    }
}

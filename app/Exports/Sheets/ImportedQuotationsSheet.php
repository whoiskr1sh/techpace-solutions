<?php

namespace App\Exports\Sheets;

use App\Models\ImportedQuotation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ImportedQuotationsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return ImportedQuotation::query();
    }

    public function title(): string
    {
        return 'Imported Quotations';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Vendor Name',
            'Country',
            'Make',
            'Model No',
            'Description',
            'Price (USD)',
            'Delivery Time',
            'Created At',
            'Updated At',
        ];
    }

    public function map($iq): array
    {
        return [
            $iq->id,
            $iq->vendor_name,
            $iq->country,
            $iq->make,
            $iq->model_no,
            $iq->description,
            $iq->price_in_usd,
            $iq->delivery_time,
            $iq->created_at,
            $iq->updated_at,
        ];
    }
}

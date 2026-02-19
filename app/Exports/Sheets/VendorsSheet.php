<?php

namespace App\Exports\Sheets;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VendorsSheet implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return Vendor::query();
    }

    public function title(): string
    {
        return 'Vendors';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Contact Person',
            'Email',
            'Phone',
            'Address',
            'GSTIN',
            'Status',
            'Created At',
        ];
    }

    public function map($vendor): array
    {
        return [
            $vendor->id,
            $vendor->name,
            $vendor->contact_person,
            $vendor->email,
            $vendor->phone,
            $vendor->address,
            $vendor->gstin,
            $vendor->status,
            $vendor->created_at,
        ];
    }
}

<?php

namespace App\Imports\Sheets;

use App\Models\ImportedQuotation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportedQuotationsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (isset($row['id'])) {
            $iq = ImportedQuotation::find($row['id']);
            if ($iq) {
                $iq->update([
                    'vendor_name' => $row['vendor_name'] ?? $iq->vendor_name,
                    'country' => $row['country'] ?? $iq->country,
                    'make' => $row['make'] ?? $iq->make,
                    'model_no' => $row['model_no'] ?? $iq->model_no,
                    'description' => $row['description'] ?? $iq->description,
                    'price_in_usd' => $row['price_usd'] ?? $iq->price_in_usd, // Assuming header 'Price (USD)' -> slug 'price_usd'
                    'delivery_time' => $row['delivery_time'] ?? $iq->delivery_time,
                ]);
                return $iq;
            }
        }

        return new ImportedQuotation([
            'vendor_name' => $row['vendor_name'],
            'country' => $row['country'] ?? null,
            'make' => $row['make'] ?? null,
            'model_no' => $row['model_no'] ?? null,
            'description' => $row['description'] ?? null,
            'price_in_usd' => $row['price_usd'] ?? null,
            'delivery_time' => $row['delivery_time'] ?? null,
        ]);
    }
}

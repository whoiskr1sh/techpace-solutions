<?php

namespace App\Imports\Sheets;

use App\Models\QuotationItem;
use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuotationItemsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // We need quotation_number to link to quotation
        $quotation = null;
        if (isset($row['quotation_number'])) {
            $quotation = Quotation::where('quotation_number', $row['quotation_number'])->first();
        }

        if (isset($row['id'])) {
            $item = QuotationItem::find($row['id']);
            if ($item) {
                $item->update([
                    'make' => $row['make'] ?? $item->make,
                    'model_no' => $row['model_no'] ?? $item->model_no,
                    'unit_price' => $row['unit_price'] ?? $item->unit_price,
                    'discount' => $row['discount'] ?? $item->discount,
                    'unit_discounted_price' => $row['unit_discounted_price'] ?? $item->unit_discounted_price,
                    'quantity' => $row['quantity'] ?? $item->quantity,
                    'total_price' => $row['total_price'] ?? $item->total_price,
                    'delivery_time' => $row['delivery_time'] ?? $item->delivery_time,
                    'remarks' => $row['remarks'] ?? $item->remarks,
                ]);
                return $item;
            }
        }

        if (!$quotation) {
            return null; // Cannot create item without quotation
        }

        return new QuotationItem([
            'quotation_id' => $quotation->id,
            'make' => $row['make'] ?? null,
            'model_no' => $row['model_no'] ?? null,
            'unit_price' => $row['unit_price'] ?? 0,
            'discount' => $row['discount'] ?? 0,
            'unit_discounted_price' => $row['unit_discounted_price'] ?? 0,
            'quantity' => $row['quantity'] ?? 1,
            'total_price' => $row['total_price'] ?? 0,
            'delivery_time' => $row['delivery_time'] ?? null,
            'remarks' => $row['remarks'] ?? null,
        ]);
    }
}

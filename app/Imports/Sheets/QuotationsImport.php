<?php

namespace App\Imports\Sheets;

use App\Models\Quotation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class QuotationsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $id = $row['id'] ?? null;

        $data = [
            'quotation_number' => $row['quotation_number'],
            'customer_name' => $row['customer_name'],
            'customer_email' => $row['customer_email'] ?? null,
            'customer_phone' => $row['customer_phone'] ?? null,
            'total_amount' => $row['total_amount'],
            'currency' => $row['currency'] ?? 'INR',
            'status' => $row['status'],
            'created_by' => Auth::id() ?? ($row['created_by_user_id'] ?? 1),
        ];

        if ($id && Quotation::withTrashed()->find($id)) {
            $q = Quotation::withTrashed()->find($id);
            $q->update($data);
            if ($q->trashed())
                $q->restore(); // Optional: Restore if updating?
            return $q;
        }

        // Prevent duplicate quotation numbers if not updating by ID
        if (Quotation::withTrashed()->where('quotation_number', $data['quotation_number'])->exists()) {
            $q = Quotation::withTrashed()->where('quotation_number', $data['quotation_number'])->first();
            $q->update($data);
            if ($q->trashed())
                $q->restore();
            return $q;
        }

        return new Quotation($data);
    }
}

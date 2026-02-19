<?php

namespace App\Imports\Sheets;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class InvoicesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $id = $row['id'] ?? null;

        $data = [
            'invoice_number' => $row['invoice_number'],
            'proforma_invoice_id' => $row['proforma_invoice_id'] ?? null,
            'sales_order_id' => $row['sales_order_id'] ?? null,
            'customer_name' => $row['customer_name'] ?? null,
            'issue_date' => $row['issue_date'] ?? null,
            'due_date' => $row['due_date'] ?? null,
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
            'created_by' => Auth::id() ?? ($row['created_by_user_id'] ?? 1),
        ];

        if ($id && Invoice::find($id)) {
            $inv = Invoice::find($id);
            $inv->update($data);
            return $inv;
        }

        if (Invoice::where('invoice_number', $data['invoice_number'])->exists()) {
            $inv = Invoice::where('invoice_number', $data['invoice_number'])->first();
            $inv->update($data);
            return $inv;
        }

        return new Invoice($data);
    }
}

<?php

namespace App\Imports\Sheets;

use App\Models\PurchaseOrder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class PurchaseOrdersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $id = $row['id'] ?? null;

        $data = [
            'po_number' => $row['po_number'],
            'vendor_id' => $row['vendor_id'],
            'sales_order_id' => $row['sales_order_id'] ?? null,
            'order_date' => $row['order_date'],
            'expected_date' => $row['expected_date'] ?? null,
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
            'created_by' => Auth::id() ?? ($row['created_by_user_id'] ?? 1),
        ];

        if ($id && PurchaseOrder::find($id)) {
            $po = PurchaseOrder::find($id);
            $po->update($data);
            return $po;
        }

        if (PurchaseOrder::where('po_number', $data['po_number'])->exists()) {
            $po = PurchaseOrder::where('po_number', $data['po_number'])->first();
            $po->update($data);
            return $po;
        }

        return new PurchaseOrder($data);
    }
}

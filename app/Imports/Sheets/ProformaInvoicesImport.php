<?php

namespace App\Imports\Sheets;

use App\Models\ProformaInvoice;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class ProformaInvoicesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $id = $row['id'] ?? null;

        $data = [
            'pi_number' => $row['pi_number'],
            'sales_order_id' => $row['sales_order_id'] ?? null,
            'customer_name' => $row['customer_name'] ?? null,
            'issue_date' => $row['issue_date'] ?? null,
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
            'created_by' => Auth::id() ?? ($row['created_by_user_id'] ?? 1),
        ];

        if ($id && ProformaInvoice::find($id)) {
            $pi = ProformaInvoice::find($id);
            $pi->update($data);
            return $pi;
        }

        if (ProformaInvoice::where('pi_number', $data['pi_number'])->exists()) {
            $pi = ProformaInvoice::where('pi_number', $data['pi_number'])->first();
            $pi->update($data);
            return $pi;
        }

        return new ProformaInvoice($data);
    }
}

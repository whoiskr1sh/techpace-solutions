<?php

namespace App\Imports\Sheets;

use App\Models\SalesOrder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class SalesOrdersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $id = $row['id'] ?? null;

        $data = [
            'so_number' => $row['so_number'],
            'quotation_id' => $row['quotation_id'],
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],
            'created_by' => Auth::id() ?? ($row['created_by_user_id'] ?? 1),
        ];

        if ($id && SalesOrder::find($id)) {
            $so = SalesOrder::find($id);
            $so->update($data);
            return $so;
        }

        if (SalesOrder::where('so_number', $data['so_number'])->exists()) {
            $so = SalesOrder::where('so_number', $data['so_number'])->first();
            $so->update($data);
            return $so;
        }

        return new SalesOrder($data);
    }
}

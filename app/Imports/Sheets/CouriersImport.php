<?php

namespace App\Imports\Sheets;

use App\Models\Courier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CouriersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Check if ID exists to update, else create
        if (isset($row['id'])) {
            $courier = Courier::withTrashed()->find($row['id']);
            if ($courier) {
                $courier->update([
                    'date' => $row['date'] ?? $courier->date,
                    'type' => $row['type'] ?? $courier->type,
                    'courier_name' => $row['courier_name'] ?? $courier->courier_name,
                    'tracking_number' => $row['tracking_number'] ?? $courier->tracking_number,
                    'recipient_name' => $row['recipient_name'] ?? $courier->recipient_name,
                    'remarks' => $row['remarks'] ?? $courier->remarks,
                    'status' => $row['status'] ?? $courier->status,
                    'shipped_at' => $row['shipped_at'] ?? $courier->shipped_at,
                    'delivered_at' => $row['delivered_at'] ?? $courier->delivered_at,
                ]);
                if ($courier->trashed())
                    $courier->restore();
                return $courier;
            }
        }

        return new Courier([
            'date' => $row['date'] ?? null,
            'type' => $row['type'] ?? null,
            'courier_name' => $row['courier_name'] ?? null,
            'tracking_number' => $row['tracking_number'] ?? null,
            'recipient_name' => $row['recipient_name'] ?? null,
            'remarks' => $row['remarks'] ?? null,
            'status' => $row['status'] ?? 'pending',
        ]);
    }
}

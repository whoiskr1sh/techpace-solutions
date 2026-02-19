<?php

namespace App\Imports\Sheets;

use App\Models\Vendor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class VendorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Skip if ID exists (handling basic upsert logic could be complex, assuming new data or unique constraints handle it)
        // ideally we might want to update if ID matches, but for now let's just create if not exists or basic create.
        // Actually, let's use firstOrNew based on unique fields if possible, or just Create.
        // Vendor has no unique constraint other than ID? Name is not unique in DB schema likely.
        // Let's do simple Create, but maybe check if ID is provided and try to update?
        // Safe bet: UpdateOrCreate by ID if provided, else Create.

        $id = $row['id'] ?? null;

        $data = [
            'name' => $row['name'],
            'contact_person' => $row['contact_person'] ?? null,
            'email' => $row['email'] ?? null,
            'phone' => $row['phone'] ?? null,
            'address' => $row['address'] ?? null,
            'gstin' => $row['gstin'] ?? null,
            'status' => in_array($row['status'], ['active', 'inactive']) ? $row['status'] : 'active',
            'created_by' => Auth::id() ?? ($row['created_by_user_id'] ?? 1), // Fallback to 1 if not auth
        ];

        if ($id && Vendor::find($id)) {
            $vendor = Vendor::find($id);
            $vendor->update($data);
            return $vendor;
        }

        return new Vendor($data);
    }
}

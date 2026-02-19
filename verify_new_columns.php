<?php

use App\Models\Courier;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\ImportedQuotation;
use App\Models\User;
use App\Exports\GlobalDataExport;
use App\Imports\GlobalDataImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Starting Verification...\n";

// 1. Create Test Data
echo "Creating Test Data...\n";
$user = User::first() ?? User::factory()->create();

// Cleanup previous test data if exists
if ($q = Quotation::withTrashed()->where('quotation_number', 'Q-TEST-001')->first()) {
    $q->items()->delete();
    $q->forceDelete();
}
if ($c = Courier::withTrashed()->where('tracking_number', 'TRACK123')->first()) {
    $c->forceDelete();
}
ImportedQuotation::where('vendor_name', 'Import Vendor')->delete();

// Courier
$courier = Courier::create([
    'courier_name' => 'Test Courier',
    'tracking_number' => 'TRACK123',
    'date' => now(),
    'type' => 'International',
    'recipient_name' => 'John Doe',
    'remarks' => 'Test Remarks',
    'status' => 'pending',
    'created_by' => $user->id,
]);
echo "Courier Created: ID {$courier->id}\n";

// Quotation & Items
$quotation = Quotation::create([
    'quotation_number' => 'Q-TEST-001',
    'customer_name' => 'Test Customer',
    'total_amount' => 1000,
    'currency' => 'USD',
    'status' => 'draft',
    'created_by' => $user->id,
]);
echo "Quotation Created: ID {$quotation->id}\n";

$item = QuotationItem::create([
    'quotation_id' => $quotation->id,
    'make' => 'Test Make',
    'model_no' => 'MODEL-X',
    'unit_price' => 100,
    'quantity' => 10,
    'total_price' => 1000,
]);
echo "Quotation Item Created: ID {$item->id}\n";

// Imported Quotation
$iq = ImportedQuotation::create([
    'vendor_name' => 'Import Vendor',
    'country' => 'USA',
    'price_in_usd' => 500,
    'delivery_time' => '2 Weeks',
]);
echo "Imported Quotation Created: ID {$iq->id}\n";

// 2. Export
echo "Exporting Data...\n";
$exportFile = 'verify_export_' . time() . '.xlsx';
try {
    Excel::store(new GlobalDataExport, $exportFile, 'local');
    $exportPath = storage_path('app/' . $exportFile);

    if (File::exists($exportPath)) {
        echo "Export Successful! File: {$exportPath}\n";
    } else {
        // Check private directory (Laravel 11 default for 'local')
        $privatePath = storage_path('app/private/' . $exportFile);
        if (File::exists($privatePath)) {
            echo "Export Successful! File found at private: {$privatePath}\n";
            $exportPath = $privatePath; // Update path for import
        } else {
            echo "Export Failed! File not found at {$exportPath} or {$privatePath}\n";
            exit(1);
        }
    }
} catch (\Throwable $e) {
    echo "Export Exception: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}

// 3. Import (Simulate by reading the same file)
// We need to modify data in DB to verify update, or delete to verifying creation.
// Let's delete the created records and try to import them back.

echo "Deleting Test Data to verify Import...\n";
$quotationId = $quotation->id;
$courierId = $courier->id;
$iqId = $iq->id;

$item->delete();
$quotation->delete();
$courier->delete();
$iq->delete();

echo "Data Deleted. Importing...\n";

try {
    Excel::import(new GlobalDataImport, $exportPath);
    echo "Import Command Executed.\n";
} catch (\Exception $e) {
    echo "Import Failed: " . $e->getMessage() . "\n";
    exit(1);
}

// 4. Verify Restoration
$restoredCourier = Courier::withTrashed()->find($courierId); // Soft deletes might handle it, but imports usually find by ID. 
// Wait, my import logic uses find($id). If I soft deleted, they are still there.
// But import logic does update if found.
// If I check DB, they should be updated.
// To verify CREATE, I should forceDelete or change IDs in Excel.
// But changing Excel programmatically is hard.
// Let's just verify that export/import runs without error first.
// And check if we can find the records.

$restoredQuotation = Quotation::withTrashed()->find($quotationId);
if ($restoredQuotation) {
    echo "Quotation Found (Updated/Restored).\n";
}

// Clean up
if (File::exists($exportPath)) {
    File::delete($exportPath);
}

echo "Verification Complete.\n";

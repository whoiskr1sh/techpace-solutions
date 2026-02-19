<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Quotation;
use App\Models\SalesOrder;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\HsnCode;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstWhere('email', 'admin@techpace.local') ?? User::first();

        if (! $admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@local',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]);
        }

        $vendor = Vendor::firstOrCreate(['name' => 'Acme Supplies'], [
            'contact_person' => 'John Doe',
            'email' => 'john@acme.test',
            'phone' => '9999999999',
            'address' => '123 Main St',
            'gstin' => 'GSTIN123',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        Quotation::firstOrCreate(['quotation_number' => 'Q-1001'], [
            'customer_name' => 'Customer A',
            'customer_email' => 'a@example.test',
            'customer_phone' => '8888888888',
            'total_amount' => 1500.00,
            'status' => 'sent',
            'created_by' => $admin->id,
        ]);

        Quotation::firstOrCreate(['quotation_number' => 'Q-1002'], [
            'customer_name' => 'Customer B',
            'customer_email' => 'b@example.test',
            'customer_phone' => '7777777777',
            'total_amount' => 2500.00,
            'status' => 'draft',
            'created_by' => $admin->id,
        ]);

        $quotation = Quotation::where('quotation_number','Q-1001')->first();
        if ($quotation) {
            SalesOrder::firstOrCreate(['so_number' => 'SO-1001'], [
                'quotation_id' => $quotation->id,
                'total_amount' => $quotation->total_amount,
                'status' => 'pending',
                'created_by' => $admin->id,
            ]);
        }

        HsnCode::firstOrCreate(['code' => '8471'], [
            'description' => 'Automatic Data Processing Machines',
            'gst_rate' => 18.00,
            'created_by' => $admin->id,
        ]);

        Invoice::firstOrCreate(['invoice_number' => 'INV-1001'], [
            'customer_name' => 'Customer A',
            'issue_date' => now()->toDateString(),
            'total_amount' => 1500.00,
            'status' => 'draft',
            'created_by' => $admin->id,
        ]);
    }
}

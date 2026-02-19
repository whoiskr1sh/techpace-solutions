<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('invoices', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('proforma_invoice_id');
            }
            if (!Schema::hasColumn('invoices', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('invoices', 'customer_phone')) {
                $table->string('customer_phone', 30)->nullable()->after('customer_email');
            }
            if (!Schema::hasColumn('invoices', 'issue_date')) {
                $table->date('issue_date')->nullable()->after('customer_phone');
            }
            if (!Schema::hasColumn('invoices', 'notes')) {
                $table->text('notes')->nullable()->after('total_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            if (Schema::hasColumn('invoices', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('invoices', 'issue_date')) {
                $table->dropColumn('issue_date');
            }
            if (Schema::hasColumn('invoices', 'customer_phone')) {
                $table->dropColumn('customer_phone');
            }
            if (Schema::hasColumn('invoices', 'customer_email')) {
                $table->dropColumn('customer_email');
            }
            if (Schema::hasColumn('invoices', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
        });
    }
};

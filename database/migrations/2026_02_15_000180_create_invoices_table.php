<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->onDelete('set null');
            $table->foreignId('proforma_invoice_id')->nullable()->constrained('proforma_invoices')->onDelete('set null');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->date('due_date')->nullable();
            $table->enum('status', ['draft','paid','partial','overdue','cancelled'])->default('draft')->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

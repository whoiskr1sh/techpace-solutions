<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proforma_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('pi_number')->unique();
            $table->foreignId('quotation_id')->nullable()->constrained('quotations')->onDelete('set null');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->enum('status', ['draft','sent','paid','cancelled'])->default('draft')->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proforma_invoices');
    }
};

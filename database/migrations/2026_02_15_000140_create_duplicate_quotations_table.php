<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duplicate_quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->foreignId('new_quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duplicate_quotations');
    }
};

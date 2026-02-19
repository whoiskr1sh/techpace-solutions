<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained('quotations')->onDelete('cascade');
            $table->string('make')->nullable();
            $table->string('model_no')->nullable(); // PART NO / MODEL NO
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->string('discount_type')->nullable(); // % or Flat? Assuming % based on 'DISC' usually being percentage, but context implies maybe value. 'unit_discounted_price' exists.
            // User said "DISC". Could be fixed amount or percentage. Often percentage. 
            // Given "UNIT DISC. PRICE" exists, maybe "DISC" is just value or percentage.
            // I'll use decimal for discount amount or percentage.
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('unit_discounted_price', 15, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->string('delivery_time')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};

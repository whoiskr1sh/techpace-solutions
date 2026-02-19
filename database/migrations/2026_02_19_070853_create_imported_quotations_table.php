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
        Schema::create('imported_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
            $table->string('country')->nullable();
            $table->string('make')->nullable();
            $table->string('model_no')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_in_usd', 15, 2)->nullable();
            $table->string('delivery_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imported_quotations');
    }
};

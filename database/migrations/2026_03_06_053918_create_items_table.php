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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->enum('type_of_item', ['SERVICE', 'TRADING']);
            $table->string('group_of_item')->nullable();
            $table->string('item_name');
            $table->text('item_description')->nullable();
            $table->string('primary_unit')->nullable();
            $table->boolean('is_freez')->default(false);
            $table->decimal('gst_percent', 5, 2)->default(0);
            $table->decimal('igst_percent', 5, 2)->default(0);
            $table->boolean('is_machine')->default(false);
            $table->string('hsn_code')->nullable();
            $table->string('account_group')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

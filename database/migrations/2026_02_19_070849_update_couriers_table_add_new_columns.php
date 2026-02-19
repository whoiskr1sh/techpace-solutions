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
        Schema::table('couriers', function (Blueprint $table) {
            // Rename if exists
            if (Schema::hasColumn('couriers', 'courier_company')) {
                $table->renameColumn('courier_company', 'courier_name');
            } else {
                if (!Schema::hasColumn('couriers', 'courier_name')) {
                    $table->string('courier_name')->nullable()->after('id');
                }
            }

            if (!Schema::hasColumn('couriers', 'type')) {
                $table->string('type')->nullable()->after('courier_name');
            }
            if (!Schema::hasColumn('couriers', 'recipient_name')) {
                $table->string('recipient_name')->nullable()->after('sales_order_id');
            }
            if (!Schema::hasColumn('couriers', 'remarks')) {
                $table->text('remarks')->nullable()->after('recipient_name');
            }
            // Add 'date' column distinct from shipped_at/delivered_at
            if (!Schema::hasColumn('couriers', 'date')) {
                $table->date('date')->nullable()->after('tracking_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('couriers', function (Blueprint $table) {
            if (Schema::hasColumn('couriers', 'date')) {
                $table->dropColumn('date');
            }
            if (Schema::hasColumn('couriers', 'remarks')) {
                $table->dropColumn('remarks');
            }
            if (Schema::hasColumn('couriers', 'recipient_name')) {
                $table->dropColumn('recipient_name');
            }
            if (Schema::hasColumn('couriers', 'type')) {
                $table->dropColumn('type');
            }
            if (Schema::hasColumn('couriers', 'courier_name')) {
                $table->renameColumn('courier_name', 'courier_company');
            }
        });
    }
};

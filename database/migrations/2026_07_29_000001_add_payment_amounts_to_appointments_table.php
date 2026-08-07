<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Cash tendered by the patient and the change (sukli) given back
            $table->decimal('amount_given', 10, 2)->nullable()->after('total_price');
            $table->decimal('change_amount', 10, 2)->nullable()->after('amount_given');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['amount_given', 'change_amount']);
        });
    }
};

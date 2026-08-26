<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Nagsusulat ang InventoryController::reactivateBatch() ng type na
 * 'reactivated', pero wala ito sa enum — kaya tinatanggihan ito ng MySQL
 * (error 1265 "Data truncated") at nagro-rollback ang buong transaction,
 * kaya hindi kailanman gumagana ang Reactivate.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicine_movements', function (Blueprint $table) {
            $table->enum('type', ['stock_in', 'stock_out', 'suspended', 'expired', 'reactivated'])->change();
        });
    }

    public function down(): void
    {
        // Ang mga naitalang 'reactivated' ay wala nang katumbas sa lumang enum;
        // gawing 'stock_in' muna para hindi sila mapurga ng column change.
        DB::table('medicine_movements')->where('type', 'reactivated')->update(['type' => 'stock_in']);

        Schema::table('medicine_movements', function (Blueprint $table) {
            $table->enum('type', ['stock_in', 'stock_out', 'suspended', 'expired'])->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Negatibo ang itinatala ng POS checkout na stock_out, samantalang positibo
 * ang lahat ng ibang movement (stock_in, Manual Decrease, suspended, expired).
 * Dahil dito, nagkakabawasan ang isa't isa sa Stock Out total ng Inventory
 * Movement report — nagpapakita ito ng -81 gayong 167 ang tamang kabuuan.
 *
 * Naayos na ang POSController; dito naman itinutuwid ang mga naunang naitala.
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('medicine_movements')
            ->where('type', 'stock_out')
            ->where('quantity', '<', 0)
            ->update(['quantity' => DB::raw('ABS(quantity)')]);
    }

    public function down(): void
    {
        // Ang benta lang mula sa POS ang dating negatibo — natatangi sila sa
        // remarks na "Sale #N". Hindi ginagalaw ang Manual Decrease.
        DB::table('medicine_movements')
            ->where('type', 'stock_out')
            ->where('quantity', '>', 0)
            ->where('remarks', 'like', 'Sale #%')
            ->update(['quantity' => DB::raw('-quantity')]);
    }
};

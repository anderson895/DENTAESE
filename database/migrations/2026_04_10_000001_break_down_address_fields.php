<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Birthplace breakdown
            $table->string('birthplace_municipality')->nullable()->after('birthplace');
            $table->string('birthplace_province')->nullable()->after('birthplace_municipality');

            // Current Address breakdown
            $table->string('address_other_details')->nullable()->after('current_address');
            $table->string('address_house_number')->nullable()->after('address_other_details');
            $table->string('address_street')->nullable()->after('address_house_number');
            $table->string('address_barangay')->nullable()->after('address_street');
            $table->string('address_municipality')->nullable()->after('address_barangay');
            $table->string('address_province')->nullable()->after('address_municipality');

            // Arrived time for appointments
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->timestamp('arrived_at')->nullable()->after('status');
        });

        // Add amount_given and change to sales table for POS receipt
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('amount_given', 10, 2)->nullable()->after('total_amount');
            $table->decimal('change_amount', 10, 2)->nullable()->after('amount_given');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birthplace_municipality', 'birthplace_province',
                'address_other_details', 'address_house_number', 'address_street',
                'address_barangay', 'address_municipality', 'address_province',
            ]);
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('arrived_at');
        });
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['amount_given', 'change_amount']);
        });
    }
};

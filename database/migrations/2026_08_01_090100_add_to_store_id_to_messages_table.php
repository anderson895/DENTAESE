<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Branch-to-branch message ng staff (Dentist / Receptionist).
     *
     * store_id    = branch na nagpadala
     * to_store_id = branch na tatanggap; null ito sa dating usapan ng
     *               pasyente at branch kaya hindi naaapektuhan ang mga
     *               lumang record.
     */
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('to_store_id')->nullable()->after('store_id');
            $table->foreign('to_store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->index(['store_id', 'to_store_id']);
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['to_store_id']);
            $table->dropIndex(['store_id', 'to_store_id']);
            $table->dropColumn('to_store_id');
        });
    }
};

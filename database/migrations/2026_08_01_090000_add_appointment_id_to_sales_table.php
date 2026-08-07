<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Dati ay hinuhulaan lang kung aling POS sale ang kabilang sa isang
     * appointment (patient + store + petsa ng appointment). Kapag hindi
     * pareho ang petsa ng bentahan at ng appointment — o walang napiling
     * pasyente sa POS — hindi lumalabas ang gamot sa resibo. Direktang
     * ugnayan na ngayon.
     */
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable()->after('patient_id');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
            $table->index('appointment_id');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropIndex(['appointment_id']);
            $table->dropColumn('appointment_id');
        });
    }
};

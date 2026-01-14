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
          if (Schema::hasColumn('appointments', 'service_name')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('service_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       if (!Schema::hasColumn('appointments', 'service_name')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->string('service_name')->nullable();
            });
        }
    }
};

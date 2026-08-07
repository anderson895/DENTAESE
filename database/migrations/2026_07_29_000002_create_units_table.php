<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        // Seed the units that were previously hard-coded in the views
        $now = now();
        DB::table('units')->insert(collect(['mL', 'G', 'MG', 'pcs', 'bottle', 'box'])
            ->map(fn ($u) => ['name' => $u, 'created_at' => $now, 'updated_at' => $now])
            ->all());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};

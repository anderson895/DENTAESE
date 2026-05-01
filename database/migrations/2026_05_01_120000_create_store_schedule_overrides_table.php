<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_schedule_overrides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->date('schedule_date');
            $table->boolean('is_open')->default(true);
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->unique(['store_id', 'schedule_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_schedule_overrides');
    }
};

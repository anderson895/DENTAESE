<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dental_teeth', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id');
            $table->string('tooth'); // e.g. 11, 21, 55
            $table->json('data')->nullable(); // JSON per tooth parts

            $table->timestamps();

            $table->unique(['patient_id', 'tooth']);

            $table->foreign('patient_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dental_teeth');
    }
};

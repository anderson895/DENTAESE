<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->string('purpose')->nullable();      // hal. appointment_confirmed, signup_otp
            $table->string('recipient')->nullable();    // normalized 639XXXXXXXXX
            $table->string('raw_number')->nullable();   // kung ano ang nakatala sa profile
            $table->text('message');
            $table->string('channel')->default('messages'); // messages | otp
            $table->string('status');                   // sent | failed | skipped
            $table->text('error')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parent_child_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('child_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('relationship')->nullable(); // e.g. mother/father/guardian
            $table->timestamps();

            $table->unique(['parent_user_id', 'child_user_id'], 'parent_child_unique');
            $table->index('child_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parent_child_links');
    }
};

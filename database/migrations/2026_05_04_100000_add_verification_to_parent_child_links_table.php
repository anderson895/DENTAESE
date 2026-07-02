<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parent_child_links', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->after('relationship');
            $table->string('verification_token', 64)->nullable()->unique()->after('status');
            $table->timestamp('token_expires_at')->nullable()->after('verification_token');
        });
    }

    public function down(): void
    {
        Schema::table('parent_child_links', function (Blueprint $table) {
            $table->dropUnique(['verification_token']);
            $table->dropColumn(['status', 'verification_token', 'token_expires_at']);
        });
    }
};

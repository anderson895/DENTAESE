<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patient_records', function (Blueprint $table) {
            $table->string('nickname')->nullable()->after('middle_name');
            $table->string('home_no')->nullable()->after('home_address');
            $table->string('office_no')->nullable()->after('office_address');
            $table->string('fax_no')->nullable()->after('office_no');
            $table->string('dental_insurance')->nullable()->after('fax_no');
            $table->date('effective_date')->nullable()->after('dental_insurance');

            $table->string('parent_guardian_name')->nullable()->after('effective_date');
            $table->string('parent_guardian_occupation')->nullable()->after('parent_guardian_name');

            $table->boolean('allergic_lidocaine')->default(false)->after('allergic');
            $table->boolean('allergic_penicillin')->default(false)->after('allergic_lidocaine');
            $table->boolean('allergic_sulfa')->default(false)->after('allergic_penicillin');
            $table->boolean('allergic_aspirin')->default(false)->after('allergic_sulfa');
            $table->boolean('allergic_latex')->default(false)->after('allergic_aspirin');
            $table->string('allergic_others')->nullable()->after('allergic_latex');

            $table->string('blood_pressure')->nullable()->after('blood_type');
            $table->boolean('profile_completed')->default(false)->after('blood_pressure');
        });
    }

    public function down(): void
    {
        Schema::table('patient_records', function (Blueprint $table) {
            $table->dropColumn([
                'nickname',
                'home_no',
                'office_no',
                'fax_no',
                'dental_insurance',
                'effective_date',
                'parent_guardian_name',
                'parent_guardian_occupation',
                'allergic_lidocaine',
                'allergic_penicillin',
                'allergic_sulfa',
                'allergic_aspirin',
                'allergic_latex',
                'allergic_others',
                'blood_pressure',
                'profile_completed',
            ]);
        });
    }
};

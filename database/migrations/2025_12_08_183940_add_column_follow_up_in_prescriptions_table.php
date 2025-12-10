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
        Schema::table('prescriptions', function (Blueprint $table) {
                 $table->text('doctor_advice')->nullable()->after('old_prescription_date');
                 $table->text('follow_up')->nullable()->after('doctor_advice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropColumn('doctor_advice');
            $table->dropColumn('follow_up');
        });
    }
};

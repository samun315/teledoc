<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Make optional columns nullable (only drug_id remains required)
        // Using raw SQL to avoid doctrine/dbal dependency
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_type_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_strength_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_dose_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_duration_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_advice_id BIGINT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert columns back to required (not nullable)
        // First, set any NULL values to 0 or a default value if needed
        // Then make columns NOT NULL
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_type_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_strength_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_dose_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_duration_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE prescription_medications MODIFY drug_advice_id BIGINT UNSIGNED NOT NULL');
    }
};

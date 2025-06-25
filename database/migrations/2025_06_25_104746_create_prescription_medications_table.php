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
        Schema::create('prescription_medications', function (Blueprint $table) {
            $table->id('prescription_medication_id');
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('drug_type_id');
            $table->unsignedBigInteger('drug_id');
            $table->unsignedBigInteger('drug_strength_id');
            $table->unsignedBigInteger('drug_duration_id');
            $table->unsignedBigInteger('drug_dose_id');
            $table->unsignedBigInteger('drug_advice_id');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('prescription_id')->references('prescription_id')->on('prescriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_medications');
    }
};

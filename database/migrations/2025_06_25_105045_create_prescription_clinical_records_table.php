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
        Schema::create('prescription_clinical_records', function (Blueprint $table) {
            $table->id('prescription_clinical_record_id');
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('subscription_type_id');
            $table->text('subscription_details');
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
        Schema::dropIfExists('prescription_clinical_records');
    }
};

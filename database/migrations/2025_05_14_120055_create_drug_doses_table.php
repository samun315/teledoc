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
        Schema::create('drug_doses', function (Blueprint $table) {
            $table->id('drug_dose_id');
            $table->unsignedBigInteger('drug_type_id');
            $table->text('drug_dose');
            $table->enum('active', ['YES', 'NO'])->default('YES');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('drug_type_id')->references('drug_type_id')->on('drug_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_doses');
    }
};

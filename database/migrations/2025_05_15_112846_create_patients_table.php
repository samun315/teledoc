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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patient_id');
            $table->string('patient_id_number');
            $table->string('name');
            $table->email('email')->nullable();
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->enum('gender',['Male', 'Female', 'Others'])->nullable();
            $table->enum('blood_group',['A+', 'B+', 'A-', 'B-','AB+', 'AB-','O+', 'O-'])->nullable();
            $table->enum('gender',['Single', 'Married', 'Divorced'])->nullable();
            $table->text('note')->nullable();
            $table->text('address')->nullable();
            $table->enum('active', ['YES', 'NO'])->default('YES');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

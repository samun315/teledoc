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
        Schema::create('doctor_earnings', function (Blueprint $table) {
            $table->id('earning_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('order_id');
            $table->decimal('consultation_fee', 10, 2)->nullable();
            $table->decimal('platform_commission', 10, 2)->nullable();
            $table->decimal('doctor_amount', 10, 2)->nullable();
            $table->enum('status', ['PENDING', 'PAID'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('doctor_id')->references('doctor_id')->on('doctors')->onDelete('cascade');
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_earnings');
    }
};

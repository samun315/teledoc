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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id('refund_id');
            $table->unsignedBigInteger('payment_id');
            $table->decimal('refund_amount', 10, 2);
            $table->string('reason', 255)->nullable();
            $table->enum('status', ['INITIATED', 'SUCCESS', 'FAILED'])->default('INITIATED');
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();

            $table->foreign('payment_id')->references('payment_id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};

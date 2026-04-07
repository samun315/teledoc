<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_instruction_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('banner_image')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });

        DB::table('payment_instruction_heroes')->insert([
            'title' => 'Pay for your consultation with confidence',
            'description' => '<p>Follow the steps for your preferred method—bKash, Nagad, or card. Account numbers and '
                .'instructions are listed below. Please read the payment terms so your booking stays valid '
                .'and we can confirm you without delay.</p>',
            'banner_image' => null,
            'status' => 'Active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_instruction_heroes');
    }
};

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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id('slider_id');
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->string('image')->nullable();
            $table->string('button_text_1')->nullable();
            $table->string('button_url_1')->nullable();
            $table->string('button_text_2')->nullable();
            $table->string('button_url_2')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};

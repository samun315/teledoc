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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon', 100)->nullable();
            $table->text('short_description');
            $table->longText('content');
            $table->string('banner_image')->nullable();
            $table->string('detail_image')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('meta_description', 160)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};

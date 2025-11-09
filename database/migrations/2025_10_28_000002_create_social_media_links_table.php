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
        Schema::create('social_media_links', function (Blueprint $table) {
            $table->id();
            $table->string('platform', 50); // facebook, twitter, instagram, etc.
            $table->string('url');
            $table->string('icon_class', 100); // icofont-facebook, etc.
            $table->enum('display_location', ['header', 'footer', 'both'])->default('both');
            $table->integer('order')->default(0);
            $table->enum('active', ['YES', 'NO'])->default('YES');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_links');
    }
};


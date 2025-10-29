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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->enum('type', ['text', 'email', 'phone', 'url', 'image', 'textarea', 'number'])->default('text');
            $table->string('group', 50)->nullable(); // general, contact, seo, etc.
            $table->string('label')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
};


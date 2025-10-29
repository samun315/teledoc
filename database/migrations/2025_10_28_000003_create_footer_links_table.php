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
        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->enum('link_type', ['internal', 'external'])->default('internal');
            $table->enum('section', ['quick_links', 'services'])->default('quick_links');
            $table->string('icon', 100)->nullable();
            $table->enum('target', ['_self', '_blank'])->default('_self');
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
        Schema::dropIfExists('footer_links');
    }
};


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
        Schema::create('expertise_sections', function (Blueprint $table) {
            $table->id('expertise_id');
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('item_1_icon')->nullable();
            $table->string('item_1_title')->nullable();
            $table->text('item_1_description')->nullable();
            $table->string('item_1_link')->nullable();
            $table->string('item_2_icon')->nullable();
            $table->string('item_2_title')->nullable();
            $table->text('item_2_description')->nullable();
            $table->string('item_2_link')->nullable();
            $table->string('item_3_icon')->nullable();
            $table->string('item_3_title')->nullable();
            $table->text('item_3_description')->nullable();
            $table->string('item_3_link')->nullable();
            $table->string('item_4_icon')->nullable();
            $table->string('item_4_title')->nullable();
            $table->text('item_4_description')->nullable();
            $table->string('item_4_link')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expertise_sections');
    }
};

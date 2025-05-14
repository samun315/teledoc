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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id('menu_item_id');
            $table->unsignedBigInteger('menu_id');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('module_item_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->enum('type',['divider','menu_item']);
            $table->string('menu_item_name');
            $table->text('url')->nullable();
            $table->text('icon_class')->nullable();
            $table->integer('order')->nullable();
            $table->string('target')->nullable();
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
        Schema::dropIfExists('menu_items');
    }
};

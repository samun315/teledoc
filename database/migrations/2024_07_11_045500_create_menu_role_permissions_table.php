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
        Schema::create('menu_role_permissions', function (Blueprint $table) {
            $table->id('menu_role_permission_id');
            $table->unsignedBigInteger('menu_permission_id');
            $table->unsignedBigInteger('role_id');
            $table->enum('active', ['YES', 'NO'])->default('YES');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('menu_permission_id')->references('menu_permission_id')->on('menu_permissions')->onDelete('cascade');
            $table->foreign('role_id')->references('role_id')->on('user_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_role_permissions');
    }
};

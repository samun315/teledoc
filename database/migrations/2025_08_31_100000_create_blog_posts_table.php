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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id('blog_id');
            $table->string('title', 100);
            $table->text('banner_image')->nullable();
            $table->longText('content');
            $table->unsignedBigInteger('category_id');
            $table->enum('status', ['Draft', 'Published', 'Scheduled'])->default('Draft');
            $table->timestamp('published_at')->nullable();
            $table->string('slug')->unique();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('blog_category_id')->on('blog_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};

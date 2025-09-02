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
        Schema::create('blog_post_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('blog_tag_id');
            $table->timestamps();

            $table->foreign('blog_id')->references('blog_id')->on('blog_posts')->onDelete('cascade');
            $table->foreign('blog_tag_id')->references('blog_tag_id')->on('blog_tags')->onDelete('cascade');

            $table->unique(['blog_id', 'blog_tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_post_tags');
    }
};

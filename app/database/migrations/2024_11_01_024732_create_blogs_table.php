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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('post_image')->nullable();
            $table->string('list_image')->nullable();
            $table->string('title');
            $table->text('short_content')->nullable();
            $table->string('author');
            $table->text('full_content');
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

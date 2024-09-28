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
        Schema::create('blog_authors', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->longText('bio')->nullable();
            $table->string('instagram_handle')->nullable();
            $table->string('twitter_handle')->nullable();
            $table->timestamps();
        });

        Schema::create('blog_categories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->boolean('visible')->default(false);            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignUlid('blog_author_id')->nullable()->cascadeOnDelete();
            $table->foreignUlid('blog_category_id')->nullable()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->date('published_at')->nullable();
            $table->string('image')->nullable();            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_links', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('url');            
            $table->json('title');
            $table->json('description');
            $table->string('color');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_authors');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('blog_posts');        
    }
};

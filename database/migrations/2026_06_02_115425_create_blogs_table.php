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
            $table->string('title');
            $table->string('slug')->unique();
            
            // longText is ideal for blog posts to accommodate large amounts of text, HTML, and embedded media
            $table->longText('content')->nullable();
            
            $table->string('featured_image')->nullable(); // Stores the file path or URL
            
            // Using timestamp allows you to schedule posts for the future
            $table->timestamp('published_at')->nullable();
            
            $table->timestamps(); // Adds created_at and updated_at
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

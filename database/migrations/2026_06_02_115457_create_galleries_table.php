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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            
            // To distinguish between media types (e.g., 'image', 'video', 'document')
            $table->string('type')->default('image');
            
            // Stores the file path or URL to where the media is hosted
            $table->string('file_path');
            
            // Nullable because not every gallery item will need a caption
            $table->string('caption', 500)->nullable();
            
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};

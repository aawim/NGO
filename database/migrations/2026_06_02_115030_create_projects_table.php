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
      Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable(); // Stores the file path or URL
            $table->string('location')->nullable();
            
            // Using decimal for precise financial calculations (15 digits total, 2 decimal places)
            $table->decimal('budget', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            
            // Status can be managed via string (e.g., 'draft', 'active', 'completed')
            $table->string('status')->default('draft');
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

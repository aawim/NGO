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
        Schema::create('causes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            
            // Decimal types to handle financial data without floating-point errors
            $table->decimal('goal_amount', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
            
            $table->string('image')->nullable(); // Stores the file path or URL
            $table->boolean('featured')->default(false);
            
            // Status managed via string (e.g., 'active', 'completed', 'paused')
            $table->string('status')->default('active');
            
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('causes');
    }
};

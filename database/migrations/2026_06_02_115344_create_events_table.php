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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            // Can store a physical address, a venue name, or a virtual meeting link
            $table->string('location')->nullable();
            // Decimal types to handle financial data without floating-point errors
            $table->decimal('goal_amount', 15, 2)->default(0.00);
            $table->decimal('raised_amount', 15, 2)->default(0.00);
           // Using dateTime instead of date to allow for specific start times (e.g., '2026-06-15 14:30:00')
            $table->dateTime('event_date')->nullable();
            $table->string('image')->nullable(); // Stores the file path or URL
            $table->boolean('featured')->default(false);
            $table->string('status')->default('active');
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

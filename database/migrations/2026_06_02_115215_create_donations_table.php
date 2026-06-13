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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            // Made user_id nullable to allow for anonymous/guest donations. 
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cause_id')->constrained()->cascadeOnDelete();
            
            // Decimal for exact financial precision
            $table->decimal('amount', 15, 2);
            
            // Payment gateway identifiers
            $table->string('transaction_id')->nullable()->unique();
            $table->string('payment_method')->nullable(); // e.g., 'stripe', 'paypal', 'bank_transfer'
            
            // Status of the payment (e.g., 'pending', 'completed', 'failed', 'refunded')
            $table->string('status')->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};

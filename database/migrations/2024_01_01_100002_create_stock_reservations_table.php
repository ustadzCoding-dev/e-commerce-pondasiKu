<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the stock_reservations table for inventory management:
     * - Temporary stock reservation during checkout process
     * - Prevents overselling by tracking reserved quantities
     * - Supports automatic cleanup of expired reservations
     *
     * Validates: Requirements 4.1, 4.2, 4.3, 4.4
     */
    public function up(): void
    {
        Schema::create('stock_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('session_id', 255); // Session identifier for guest/user checkout
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('quantity');
            $table->timestamp('expires_at'); // Reservation expiration timestamp
            $table->timestamps();

            // Indexes for efficient queries
            $table->index('session_id');
            $table->index('expires_at');
            $table->index('product_id');
            $table->index(['product_id', 'session_id']);

            // Optional: Add unique constraint to prevent duplicate reservations per session/product
            $table->unique(['product_id', 'session_id'], 'unique_product_session_reservation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_reservations');
    }
};

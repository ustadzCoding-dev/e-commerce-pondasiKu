<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the payment_transactions table for payment transaction logging:
     * - Records all payment transactions for audit purposes
     * - Supports multiple payment gateways (Midtrans, Stripe)
     * - Stores gateway response for debugging and reconciliation
     *
     * Validates: Requirements 3.4, 3.6, 6.6
     */
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('gateway', 50); // e.g., 'midtrans', 'stripe'
            $table->string('transaction_id', 255); // Transaction ID from the payment gateway
            $table->string('transaction_type', 50)->default('payment'); // payment, refund, partial_refund
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('IDR');
            $table->string('status', 50); // pending, success, failed, cancelled, refunded
            $table->json('gateway_response')->nullable(); // Full response from gateway
            $table->text('notes')->nullable(); // Additional notes or error messages
            $table->string('ip_address', 45)->nullable(); // IP address of the request
            $table->foreignId('processed_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamps();

            // Unique constraint to prevent duplicate transaction records
            $table->unique(['gateway', 'transaction_id'], 'unique_gateway_transaction');

            // Indexes for efficient queries
            $table->index('order_id');
            $table->index('status');
            $table->index('gateway');
            $table->index('transaction_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};

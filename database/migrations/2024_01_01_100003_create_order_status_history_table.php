<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the order_status_history table for comprehensive order lifecycle tracking:
     * - Records all status changes with timestamps
     * - Supports audit trail for order management
     * - Tracks who made each status change and why
     *
     * Validates: Requirements 5.1, 5.2, 5.3, 6.3
     */
    public function up(): void
    {
        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('from_status', 50)->nullable(); // Can be null for initial status
            $table->string('to_status', 50);
            $table->text('reason')->nullable(); // Reason for status change
            $table->foreignId('changed_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->timestamp('changed_at')->useCurrent();
            $table->string('ip_address', 45)->nullable(); // IP address of who made the change
            $table->text('metadata')->nullable(); // Additional JSON metadata

            // Indexes for efficient queries
            $table->index('order_id');
            $table->index('changed_at');
            $table->index('to_status');
            $table->index('changed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_status_history');
    }
};

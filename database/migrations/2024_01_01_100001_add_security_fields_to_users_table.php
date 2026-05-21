<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds security-related fields to the users table for:
     * - Multi-factor authentication (MFA) support
     * - Login tracking and account lockout protection
     * - Role-based access control
     *
     * Validates: Requirements 1.1, 2.1, 2.4
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Phone number for additional contact
            $table->string('phone', 20)->nullable()->after('email');

            // Role-based access control (replaces isAdmin boolean)
            $table->enum('role', ['customer', 'admin', 'staff'])->default('customer')->after('phone');

            // Multi-factor authentication fields
            $table->boolean('mfa_enabled')->default(false)->after('role');
            $table->string('mfa_secret', 255)->nullable()->after('mfa_enabled');
            $table->text('backup_codes')->nullable()->after('mfa_secret'); // Will store encrypted JSON

            // Login tracking for security
            $table->timestamp('last_login_at')->nullable()->after('backup_codes');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at'); // IPv6 compatible
            $table->unsignedInteger('failed_login_attempts')->default(0)->after('last_login_ip');
            $table->timestamp('locked_until')->nullable()->after('failed_login_attempts');

            // Index for faster role-based queries
            $table->index('role');
            $table->index('locked_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['locked_until']);

            $table->dropColumn([
                'phone',
                'role',
                'mfa_enabled',
                'mfa_secret',
                'backup_codes',
                'last_login_at',
                'last_login_ip',
                'failed_login_attempts',
                'locked_until',
            ]);
        });
    }
};

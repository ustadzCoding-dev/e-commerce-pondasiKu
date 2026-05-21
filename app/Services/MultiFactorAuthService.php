<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Google2FA;

/**
 * Multi-Factor Authentication Service
 * 
 * Provides TOTP (Time-based One-Time Password) generation and verification,
 * backup code management, and MFA-related security features.
 * 
 * @package App\Services
 */
class MultiFactorAuthService
{
    /**
     * Time window for TOTP verification (in seconds)
     */
    private const TOTP_WINDOW = 1;

    /**
     * Number of backup codes to generate
     */
    private const BACKUP_CODE_COUNT = 8;

    /**
     * Length of each backup code
     */
    private const BACKUP_CODE_LENGTH = 8;

    /**
     * Rate limiting duration in minutes
     */
    private const RATE_LIMIT_DURATION = 15;

    /**
     * Maximum verification attempts before lockout
     */
    private const MAX_VERIFICATION_ATTEMPTS = 5;

    /**
     * Google2FA instance
     */
    private Google2FA $google2fa;

    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }

    /**
     * Generate a new TOTP secret for a user.
     *
     * @return string The generated secret key
     */
    public function generateSecret(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Generate TOTP QR code URL for authenticator app setup.
     *
     * @param User $user
     * @param string $secret
     * @return string QR code URL
     */
    public function generateQRCodeUrl(User $user, string $secret): string
    {
        $companyName = config('app.name', 'Pondasiku');
        $email = $user->email;

        return $this->google2fa->getQRCodeUrl($companyName, $email, $secret);
    }

    /**
     * Verify a TOTP code against a user's secret.
     *
     * @param User $user
     * @param string $code
     * @return bool True if verification succeeds
     */
    public function verifyTOTP(User $user, string $code): bool
    {
        if (!$user->mfa_enabled || empty($user->mfa_secret)) {
            return false;
        }

        // Check rate limiting
        if ($this->isRateLimited($user)) {
            return false;
        }

        $secret = Crypt::decryptString($user->mfa_secret);
        
        $valid = $this->google2fa->verifyKey(
            $secret,
            $code,
            self::TOTP_WINDOW
        );

        if ($valid) {
            $this->clearRateLimit($user);
            $this->recordSuccessfulVerification($user);
        } else {
            $this->recordFailedAttempt($user);
        }

        return $valid;
    }

    /**
     * Generate backup codes for MFA recovery.
     *
     * @return array Array of backup codes
     */
    public function generateBackupCodes(): array
    {
        $codes = [];
        
        for ($i = 0; $i < self::BACKUP_CODE_COUNT; $i++) {
            $codes[] = $this->generateSingleBackupCode();
        }

        return $codes;
    }

    /**
     * Verify a backup code for MFA recovery.
     *
     * @param User $user
     * @param string $code
     * @return bool True if verification succeeds
     */
    public function verifyBackupCode(User $user, string $code): bool
    {
        if (!$user->mfa_enabled || empty($user->backup_codes)) {
            return false;
        }

        // Check rate limiting
        if ($this->isRateLimited($user)) {
            return false;
        }

        $backupCodes = $user->backup_codes;
        $normalizedCode = strtoupper(preg_replace('/[^A-Z0-9]/', '', $code));

        foreach ($backupCodes as $index => $storedCode) {
            if (Hash::check($normalizedCode, $storedCode)) {
                // Remove the used backup code
                unset($backupCodes[$index]);
                $user->backup_codes = array_values($backupCodes);
                $user->save();

                $this->clearRateLimit($user);
                $this->recordSuccessfulVerification($user);

                return true;
            }
        }

        $this->recordFailedAttempt($user);
        
        return false;
    }

    /**
     * Enable MFA for a user.
     *
     * @param User $user
     * @param string $secret
     * @param array $backupCodes
     * @return bool
     */
    public function enableMFA(User $user, string $secret, array $backupCodes): bool
    {
        $user->mfa_enabled = true;
        $user->mfa_secret = Crypt::encryptString($secret);
        $user->backup_codes = $this->hashBackupCodes($backupCodes);
        
        return $user->save();
    }

    /**
     * Disable MFA for a user.
     *
     * @param User $user
     * @return bool
     */
    public function disableMFA(User $user): bool
    {
        $user->mfa_enabled = false;
        $user->mfa_secret = null;
        $user->backup_codes = null;
        
        return $user->save();
    }

    /**
     * Check if user has MFA enabled.
     *
     * @param User $user
     * @return bool
     */
    public function hasMFAEnabled(User $user): bool
    {
        return $user->mfa_enabled === true;
    }

    /**
     * Record a failed verification attempt.
     *
     * @param User $user
     * @return void
     */
    private function recordFailedAttempt(User $user): void
    {
        $cacheKey = "mfa_attempts_{$user->id}";
        $attempts = Cache::get($cacheKey, 0) + 1;
        
        Cache::put($cacheKey, $attempts, now()->addMinutes(self::RATE_LIMIT_DURATION));
    }

    /**
     * Check if user is rate limited for MFA verification.
     *
     * @param User $user
     * @return bool
     */
    private function isRateLimited(User $user): bool
    {
        $cacheKey = "mfa_attempts_{$user->id}";
        $attempts = Cache::get($cacheKey, 0);
        
        return $attempts >= self::MAX_VERIFICATION_ATTEMPTS;
    }

    /**
     * Clear the rate limit for MFA verification.
     *
     * @param User $user
     * @return void
     */
    private function clearRateLimit(User $user): void
    {
        Cache::forget("mfa_attempts_{$user->id}");
    }

    /**
     * Record a successful MFA verification.
     *
     * @param User $user
     * @return void
     */
    private function recordSuccessfulVerification(User $user): void
    {
        $user->last_mfa_at = now();
        $user->save();
    }

    /**
     * Generate a single backup code.
     *
     * @return string
     */
    private function generateSingleBackupCode(): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        
        for ($i = 0; $i < self::BACKUP_CODE_LENGTH; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }
        
        return $code;
    }

    /**
     * Hash backup codes for secure storage.
     *
     * @param array $codes
     * @return array
     */
    private function hashBackupCodes(array $codes): array
    {
        return array_map(fn($code) => Hash::make($code), $codes);
    }

    /**
     * Get remaining backup codes count.
     *
     * @param User $user
     * @return int
     */
    public function getRemainingBackupCodesCount(User $user): int
    {
        if (empty($user->backup_codes)) {
            return 0;
        }
        
        return count($user->backup_codes);
    }

    /**
     * Check if user should regenerate backup codes.
     *
     * @param User $user
     * @return bool
     */
    public function shouldRegenerateBackupCodes(User $user): bool
    {
        return $user->mfa_enabled && $this->getRemainingBackupCodesCount($user) <= 2;
    }
}

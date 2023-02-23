<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait TwoFactorAuthenticatable
{
    private $codeLength = 10;
    private $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-={}[]|\\:;\"',.?/~`";


    /**
     * Generate a new recovery code.
     *
     * @return string
     */
    public static function generateRecoveryCode(): string
    {
        return Str::random(10) . '-' . Str::random(10);
    }
    /**
     * Determine if two-factor authentication has been enabled And Confirmed.
     *
     * @return bool
     */
    public function hasEnabledTwoFactorAuthenticationConfirmed(): bool
    {
        return is_null($this->two_factor_secret) &&
            !is_null($this->two_factor_confirmed_at);
    }

    /**
     * Determine if two-factor authentication has been enabled not Confirmed.
     *
     * @return bool
     */
    public function hasEnabledTwoFactorAuthenticationNotConfirmed(): bool
    {
        return !is_null($this->two_factor_secret) &&
            is_null($this->two_factor_confirmed_at);
    }

    public function hasDisabledTwoFactorAuthentication(): bool
    {
        return is_null($this->two_factor_secret) &&
            is_null($this->two_factor_confirmed_at) &&
            is_null($this->two_factor_recovery_codes);
    }

    /**
     * Get the user's two factor authentication recovery codes.
     *
     * @return array
     */
    public function recoveryCodes(): array
    {
        return json_decode(decrypt($this->two_factor_recovery_codes), true);
    }
    /**
     * generate a secret Key .
     *
     * @return string
     */
    public function generateSecretKey(): string
    {

        $secretKey = "";
        $maxIndex = strlen($this->alphabet) - 1;
        for ($i = 0; $i < $this->codeLength; $i++) {
            $index = rand(0, $maxIndex);
            $secretKey .= $this->alphabet[$index];
        }
        return $secretKey;
    }
}

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
    public static function generate()
    {
        return Str::random(10) . '-' . Str::random(10);
    }
    /**
     * Determine if two-factor authentication has been enabled.
     *
     * @return bool
     */
    public function hasEnabledTwoFactorAuthentication()
    {
        return !is_null($this->two_factor_secret) &&
            !is_null($this->two_factor_confirmed_at);
    }

    /**
     * Get the user's two factor authentication recovery codes.
     *
     * @return array
     */
    public function recoveryCodes()
    {
        return json_decode(decrypt($this->two_factor_recovery_codes), true);
    }

    public function generateSecretKey()
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

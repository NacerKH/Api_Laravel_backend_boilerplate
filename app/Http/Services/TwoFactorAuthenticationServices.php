<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Traits\TwoFactorAuthenticatable;
use App\Models\User;
use Illuminate\Support\Collection;

class TwoFactorAuthenticationServices

{



    public function __construct(private User $user)
    {
    }
    /**
     * Generate new recovery codes for the user.
     *
     * @return void
     */
    public function RegenerateNewRecoveryCodes()
    {
        $this->user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return $this->user->generate();
            })->all())),
        ])->save();
    }


    /**
     * Replace the given recovery code with a new one in the user's stored codes.
     *
     * @param  string  $code
     * @return void
     */
    public function replaceRecoveryCode($code)
    {
        $this->user->forceFill([
            'two_factor_recovery_codes' => encrypt(str_replace(
                $code,
                $this->user->generate(),
                decrypt($this->user->two_factor_recovery_codes)
            )),
        ])->save();
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @return void
     */
    public function EnableTwoFactorAuthentication()
    {
        $this->user->forceFill([
            'two_factor_secret' => encrypt($this->user->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return $this->user->generate();
            })->all())),
        ])->save();
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @return void
     */
    public function _DisableTwoFactorAuthentication()
    {
        if (
            !is_null(optional($this->user)->two_factor_secret) ||
            !is_null(optional($this->user)->two_factor_recovery_codes) ||
            !is_null(optional($this->user)->two_factor_confirmed_at)
        ) {
            $this->user->forceFill(
                [
                    'two_factor_secret' => null,
                    'two_factor_recovery_codes' => null,
                    'two_factor_confirmed_at' => null,
                ]
            )->save();
        }
    }
}

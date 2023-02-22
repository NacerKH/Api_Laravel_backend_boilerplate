<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Traits\TwoFactorAuthenticatable;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Http\Response;

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
    public function regenerateNewRecoveryCodes()
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
    public function enableTwoFactorAuthentication()
    {
        $this->user->forceFill([
            'two_factor_secret' => encrypt($this->user->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () {
                return $this->user->generate();
            })->all())),
        ])->save();
    }

    /**
     * confirm two factor authentication for the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmTwoFactorAuthentication(string $code)
    {
        return $this->_VerifyTwoFactorAuthenticationKeyIdentic($code) ?
            response()->json(['message' => 'Two-factor authentication confirmed.','data' => $this->user->forceFill([
                        'two_factor_secret' => null,'two_factor_confirmed_at' => now(),])->save() ], Response::HTTP_OK) : 
             response()->json(['message' => 'Invalid two-factor authentication code.'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * Disable two factor authentication for the user.
     *
     * @return void
     */
    public function disableTwoFactorAuthentication()
    {
        if (
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



    /**
     * Verify two factor authentication for the user.
     *
     * @return bool
     */
    private function _VerifyTwoFactorAuthenticationKeyIdentic($code): bool
    {
        return  decrypt($this->user->two_factor_secret) == $code;
    }
}

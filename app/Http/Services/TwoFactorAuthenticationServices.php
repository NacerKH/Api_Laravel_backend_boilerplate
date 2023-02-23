<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class TwoFactorAuthenticationServices

{

    /**
     * regenerateNewRecoveryCodes
     *
     * @param  mixed  $user
     * @return void
     */
    public function regenerateNewRecoveryCodes(User $user)
    {
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () use ($user) {
                return $user->generateRecoveryCode();
            })->all())),
        ])->save();
    }


    /**
     * Replace the given recovery code with a new one in the user's stored codes.
     *
     * @param  string  $code
     * @return void
     */
    public function replaceRecoveryCode($code, User $user)
    {
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(str_replace(
                $code,
                $user->generateRecoveryCode(),
                decrypt($user->two_factor_recovery_codes)
            )),
        ])->save();
    }

    /**
     * Enable two factor authentication for the user.
     *
     * @return void
     */
    public function enableTwoFactorAuthentication(User $user)
    {

        $user->forceFill([
            'two_factor_secret' => encrypt($user->generateSecretKey()),
            'two_factor_recovery_codes' => encrypt(json_encode(Collection::times(8, function () use ($user) {
                return $user->generateRecoveryCode();
            })->all())),
        ])->save();
    }

    /**
     * confirm two factor authentication for the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirmTwoFactorAuthentication(string $code, User $user)
    {
        return  $this->_VerifyTwoFactorAuthenticationKeyIdentic($code, $user) ?
            response()->json(['message' => 'Two-factor authentication confirmed.', 
            'data' => $user->forceFill(['two_factor_secret' => null, 'two_factor_confirmed_at' => now(),])->save()],
             Response::HTTP_OK) :
            response()->json(['message' => 'Invalid two-factor authentication code.'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function confirmTwoFactorAuthenticationWithRecoveryCodes(string $code, User $user)
    {
        return
            $this->_VerifyTwoFactorAuthenticationWithRecoveryCodes($code, $user) ?
            $user->forceFill(['two_factor_secret' => null, 'two_factor_confirmed_at' => now()])
            ->save() && $this->replaceRecoveryCode($code, $user)

            : response()->json(['message' => 'Invalid two-factor authentication code.'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Disable two factor authentication for the user.
     *
     * @return void
     */
    public function disableTwoFactorAuthentication(User $user)
    {
        if (
            !is_null(optional($user)->two_factor_recovery_codes) ||
            !is_null(optional($user)->two_factor_confirmed_at)
        ) {
            $user->forceFill(
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
    private function _VerifyTwoFactorAuthenticationKeyIdentic($code, User $user): bool
    {
        return  decrypt($user->two_factor_secret) == $code;
    }
    /**
     * Verify two factor authentication for the user exist .
     *
     * @return bool
     */
    private function _VerifyTwoFactorAuthenticationWithRecoveryCodes($code, User $user): bool
    {
        return  in_array($code, $user->recoveryCodes());
    }
}

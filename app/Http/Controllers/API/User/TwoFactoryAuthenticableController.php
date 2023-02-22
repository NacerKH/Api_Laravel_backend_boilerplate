<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Services\TwoFactorAuthenticationServices;
use App\Models\User;
use Illuminate\Http\Request;

class TwoFactoryAuthenticableController extends BaseController
{



    /**
     * __construct
     *
     * @param  mixed $TwoFactorAuthenticationServices
     * 
     * @return void
     */
    public function __construct(private TwoFactorAuthenticationServices $TwoFactorAuthenticationServices)
    {
    }

    /**
     * storeTwoFactoryAuthenticable
     *
     * @return void
     */
    public function storeTwoFactoryAuthenticable()
    {
        return $this->TwoFactorAuthenticationServices->enableTwoFactorAuthentication(request()->user());
    }

    /**
     * confirmationTwoFactoryAuthenticable
     *
     * @param  string $code
     * @return void
     */
    public function confirmationTwoFactoryAuthenticable(string $code)
    {
        return $this->TwoFactorAuthenticationServices->confirmTwoFactorAuthentication($code, request()->user());
    }

    /**
     * disableMfa
     *
     * @return void
     */
    public function disableMfa()
    {
        return $this->TwoFactorAuthenticationServices->disableTwoFactorAuthentication(request()->user());
    }


    /**
     * getRecoveryCodes
     *
     * @return \Illuminate\Http\Response 
     */
    public function getRecoveryCodes()
    {

        return !empty(auth()->user()->two_factor_recovery_codes)
            ? $this->sendResponse(auth()->user()->recoveryCodes(), 'retrieve Recovery codes  successfully.')
            : $this->sendError('Please Enable Mfa to retrieve your RecoveryCodes !!');
    }

    /**
     * confirmation Mfa With RecoveryCodes
     *
     * @param  string $code
     * @return void
     */
    public function confirmMfaWithRecoveryCodes(string $code)
    {

        return $this->TwoFactorAuthenticationServices->confirmTwoFactorAuthenticationWithRecoveryCodes($code, request()->user());
    }

    /**
     * regenerate New Recovery Codes
     *
     * @return void
     */
    public function regenerateNewRecoveryCodes()
    {
        return $this->TwoFactorAuthenticationServices->regenerateNewRecoveryCodes(request()->user());
    }
}

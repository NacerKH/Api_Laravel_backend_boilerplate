<?php

use App\Http\Controllers\API\Authentification\AuthController;
use App\Http\Controllers\API\Authentification\ForgotPasswordController;
use App\Http\Controllers\API\Authentification\RegisterController;
use App\Http\Controllers\API\Authentification\Verification\VerificationController;
use App\Http\Controllers\API\User\SocialController;
use App\Http\Controllers\API\User\TwoFactoryAuthenticableController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('Mfa')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');;
    Route::post('/verify-resend', [VerificationController::class, 'resend']);
    ## Update user informations Profil & Password
    Route::post('/updateUserInformationProfil', [UserController::class, 'update'])->name('user.updateProfil');
    Route::post('/updateUserPassword', [UserController::class, 'updatePassword'])->name('user.update.password');

    Route::get('/disable-mfa', [TwoFactoryAuthenticableController::class, 'disableMfa'])->name('user.disable.mfa');
    Route::post('/regenerate-recovery-codes', [TwoFactoryAuthenticableController::class, 'regenerateNewRecoveryCodes'])->name('user.regnerate.mfa.recovery.codes');
});
    Route::get('/recovery-codes', [TwoFactoryAuthenticableController::class, 'getRecoveryCodes'])->name('user.recovery.codes');

    Route::post('/confirm-mfa-recovery-code/{code}', [TwoFactoryAuthenticableController::class, 'confirmMfaWithRecoveryCodes'])->name('user.confirm.mfa.recovery.code');
    Route::post('/send-otp-code', [TwoFactoryAuthenticableController::class, 'sendSecretCode'])->name('user.send.otp.code');
    Route::post('/enable-mfa', [TwoFactoryAuthenticableController::class, 'storeTwoFactoryAuthenticable'])->name('user.enable.mfa');
    Route::post('/confirm-mfa-secretkey/{code}', [TwoFactoryAuthenticableController::class, 'confirmationTwoFactoryAuthenticable'])->name('user.confirm.mfa.secret');
});

Route::middleware('guest')->group(function () {
    # guest auth
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::post('/register', [RegisterController::class, 'register'])->name('user.register');
    # guest reset password (temporary link)
    Route::post('/PasswordResetLink', [ForgotPasswordController::class, 'PasswordResetLink'])->name('PasswordResetLink');

    Route::post('/ForgotPassword', [ForgotPasswordController::class, 'reset'])->name('password.reset');
    Route::get('/redirect/{service}', [SocialController::class, 'redirect'])->name('redirect');

    Route::get('/callback/{service}', [SocialController::class, 'callback'])->name('callback');
});

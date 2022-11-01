<?php

use App\Http\Controllers\API\Authentification\AuthController;
use App\Http\Controllers\API\Authentification\ForgotPasswordController;
use App\Http\Controllers\API\Authentification\RegisterController;
use App\Http\Controllers\API\Authentification\Verification\VerificationController;
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
    Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');;
    Route::post('/verify-resend', [VerificationController::class, 'resend']);

    ## Update user informations Profil & Password
    Route::post('/updateUserInformationProfil',[UserController::class, 'update'])->name('user.updateProfil');
    Route::post('/updateUserPassword',[UserController::class, 'updatePassword'])->name('user.update.password');
});

Route::middleware('guest')->group(function () {
    # guest auth
    Route::post('/login', [AuthController::class, 'login'])->name('user.login');
    Route::post('/register', [RegisterController::class,'register'])->name('user.register');
    # guest reset password (temporary link)
    Route::post('/PasswordResetLink',[ForgotPasswordController::class, 'PasswordResetLink'])->name('PasswordResetLink');

    Route::post('/ForgotPassword',[ForgotPasswordController::class, 'reset'])->name('password.reset');

});

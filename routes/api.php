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
    Route::post('/ForgotPassword',ForgotPasswordController::class);
    ## Update user informations Profil
    Route::post('/updateUserInformationProfil',[UserController::class, 'update']);
});

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [RegisterController::class,'register'])->name('user.register');


    // guest verification (temporary auth)

});

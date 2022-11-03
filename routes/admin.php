<?php

use App\Http\Controllers\API\Authentification\AuthController;
use App\Http\Controllers\API\Authentification\ForgotPasswordController;
use App\Http\Controllers\API\Authentification\RegisterController;
use App\Http\Controllers\API\Authentification\Verification\VerificationController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|  Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin and api " middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum','isAdmin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/verify-email/{id}/{hash}', [VerificationController::class, 'verify'])->name('admin.verification.verify');;
    Route::post('/verify-resend', [VerificationController::class, 'resend']);

    ## Update user informations Profil & Password
    Route::post('/updateUserInformationProfil',[UserController::class, 'update'])->name('admin.updateProfil');
    Route::post('/updateUserPassword',[UserController::class, 'updatePassword'])->name('admin.update.password');
});



<?php

namespace App\Http\Controllers\API\Authentification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if (!$this->guard()->attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], Response::HTTP_UNAUTHORIZED);
        }
        $this->guard()->attempt($credentials);
        $token = $this->guard()->user()->createToken('auth-token')->plainTextToken;
        return $this->sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => auth()->user(),
        ], 'user logged in  Succesfuly');
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $this->guard()->logout();
        return $this->sendResponse(['status_code' => '200'], 'logged out successfully');
    }

    public function guard($guard = 'web')
    {
        return Auth::guard($guard);
    }
}

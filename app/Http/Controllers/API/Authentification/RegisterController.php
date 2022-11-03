<?php

namespace App\Http\Controllers\API\Authentification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data    = $request->validate([
            "name" => "required|string|min:5",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|string|confirmed"
        ]);




        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        if ($user) {
            event(new Registered($user));
            $user_role = Role::where('slug','user')->first();
            $user->roles()->attach($user_role);
            $success['token'] =  $user->createToken('auth-token')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        }
    }
}

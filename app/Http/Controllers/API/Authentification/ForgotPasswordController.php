<?php

namespace App\Http\Controllers\API\Authentification;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Traits\PasswordValidationRules;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends BaseController
{
    use PasswordValidationRules;

     public function reset(Request $request)
     {
         $user = $request->user();
         $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => $this->passwordRules(),
         ]);
          // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            fn($user)=>$user->forceFill(['password' => Hash::make($request->password),'remember_token' => Str::random(60)])->save(),

                event(new PasswordReset($user))

        );
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET?response()->json(['message'=>__($status)],Response::HTTP_OK):
        response()->json(['message'=>__($status)],Response::HTTP_NOT_FOUND);
     }


     /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     public function PasswordResetLink(Request $request){
        $request->validate([
            'email' => ['required', 'email'],
        ]);

          // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return($status == Password::RESET_LINK_SENT)?response()->json(['message'=>__($status)],Response::HTTP_OK):response()->json(['message'=>__($status)],Response::HTTP_NOT_FOUND);


     }



}

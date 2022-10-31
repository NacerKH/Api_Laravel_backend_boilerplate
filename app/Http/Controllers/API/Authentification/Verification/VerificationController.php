<?php

namespace App\Http\Controllers\API\Authentification\Verification;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends BaseController
{


    public function verify($user_id, EmailVerificationRequest $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }

        $user = User::findOrFail($user_id);


        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return  response()->json()->isOk();
    }

    public function resend(Request $request) {

        if ($request->user()->hasVerifiedEmail()) {
            return  $this->sendError(["msg" => "Email already verified."], Response::HTTP_BAD_REQUEST);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }
}

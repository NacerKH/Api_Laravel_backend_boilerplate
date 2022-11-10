<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\SocialiteTrait;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Socialite;

class SocialController extends Controller
{   use SocialiteTrait;
    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service, Request $request)
    {
        $userSocialite = Socialite::driver($service)->stateless()->user();
        $facebookUser = User::where('fb_id', $userSocialite->id)->first();
        $googleUser = User::where('google_id',  $userSocialite->id)->first();
        return match($service){
         'facebook'=> $this->signInOrSignUpSocialite( $userSocialite, $facebookUser,'fb'),
         'google'=>   $this->signInOrSignUpSocialite( $userSocialite, $googleUser,'google'),
         default=> throw new  InvalidArgumentException('No services expected'),
             };



            }





}

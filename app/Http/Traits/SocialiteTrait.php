<?php

namespace App\Http\Traits;

use App\Models\Permission;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait SocialiteTrait {
  // dependency injection
  public function __construct(private Role $user_role)
  {
    $this->role= $user_role->where('slug','user')->first();
  }

   public function signInOrSignUpSocialite( $userSocialite, $user,$service)
   {
        if (empty( $user)){
          $data= $this->createUserDependService($service,$userSocialite);
           $createUser = User::create($data);
           $createUser->roles()->attach($this->role);
           Auth::login($createUser);
         return $this->sendResponse([
               'access_token' =>  $this->create_token($createUser),
               'token_type' => 'Bearer',
           ]);

        };

       Auth::login($user);
       return $this->sendResponse([
           'access_token' =>  $this->create_token($user),
           'token_type' => 'Bearer',
       ], 'user logged in  Succesfuly');



    }


    private function create_token($user)
    {
        return  $user->createToken('auth-token')->plainTextToken;
    }
    private function createUserDependService($service,$userSocialite){
             $fbData=[
                'name' => $userSocialite->name,
                'email' => isset( $userSocialite->email) ?  $userSocialite->email : null,
                'fb_id' =>  $userSocialite->id,
                'password' => Hash::make('kali@123'), //change to random
             ];
             $googleData=[
                'name' => $userSocialite->name,
                'email' => isset( $userSocialite->email) ?  $userSocialite->email : null,
                'google_id' =>  $userSocialite->id,
                'password' => Hash::make('kali@123'), //change to random
             ];


            return match ($service){
                    'fb' => $fbData,
                    'google'=> $googleData
                 };
              }

}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;

class TwoFactoryAuthenticatableTest extends TestCase
{
    /**
     * a user can enable mfa
     *
     * @return void
     */
    public function test_user_can_enable_Mfa()
    {   
        $user=User::factory()->create();//prapare data

        $this->actingAs($user);  //make authorization test 

        $response = $this->postJson(route('user.enable.mfa'));

        $response->assertStatus(200);
    }

    /**
     * a user can enable mfa
     *
     * @return void
     */
    public function test_user_can_verify_Mfa_code()
    {     
        $code="123456";
        $user=User::factory()->create();//prapare data
          $this->actingAs($user);  //make authorization test 

         $user->forceFill(['two_factor_secret'=> encrypt($code)]);

        $response = $this->postJson(route('user.confirm.mfa.secret',$code));

        $response->assertStatus(200);
    }

        /**
         * a user can't enable mfa with a wrong code 
         *
         * @return void
         */
        public function test_user_can_verify_Mfa_code_with_wrong_code()
        {     
            $code="123456";

            $user=User::factory()->create();//prapare data
            $this->actingAs($user);  //make authorization test 

            $user->forceFill(['two_factor_secret'=> encrypt($code)]);
            $WrongCode="WrongCOde";
            $response = $this->postJson(route('user.confirm.mfa.secret',$WrongCode));

            $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
}

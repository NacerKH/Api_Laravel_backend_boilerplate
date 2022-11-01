<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     *User can change his password
     *
     * @return void
     */
    public function test_a_user_can_change_his_password()
    {

      $user=User::factory()->create();//prapare data

      $this->actingAs($user);  //make authorization test ||
    //   vscode Read $user as issue a cuz it'snt seen $user like Model extends authorization but it work like that
      $response=$this->postJson(route('user.update.password'),[ //make request
        'password_confirmation'=>"newPassword9@.",
        'password'=>"newPassword9@.",
        'current_password'=>"password",
      ]);
      $user=User::find($user->id);
      $response->assertOk();//test response
      $this->assertTrue(Hash::check('newPassword9@.',   $user->password));
    }
}

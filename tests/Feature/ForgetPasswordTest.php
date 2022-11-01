<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Reset link
     *
     * @return void
     */
    public function test_user_can_send_a_reset_link()
    {
        $user=User::factory()->create(["email" => "foulen@example.com"]);
        $response= $this->postJson(route('PasswordResetLink'),['email' => "foulen@example.com"]);
        $response->assertOk();
       Notification::assertSentTo($user,ResetPassword::class);


    }
    public function test_password_can_be_reset_with_valid_token()
{


     $user = User::factory()->create(['password'=>"Kali9@skhe"]);

     $response=  $this->postJson(route('PasswordResetLink'), ['email' => $user->email]);
     $response->assertOk();
     $token = null;
     Notification::assertSentTo($user, ResetPassword::class,  function ($notification) use (&$token) {
        $token = $notification->token;
        return 1;
    });
     $responseReset = $this->postJson(route('password.reset'), [
        "email" => $user->email,
        "token" => $token,
        "password" => "newpasswordKali9@skhe",
        "password_confirmation" => "newpasswordKali9@skhe"
    ]);
    $responseReset->assertOk();

}



}

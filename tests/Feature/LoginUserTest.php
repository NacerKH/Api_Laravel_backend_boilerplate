<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A user  can login with email and password .
     *
     * @return void
     */
    public function test_a_user_can_login_with_email_and_password()
    {
        $creadentials = [
            "email" =>  "foulen@example.com",
            "password" =>  "password",
        ];
        User::factory()->create(["email" => $creadentials["email"]]);

        $response = $this->postJson(route("user.login"), $creadentials);

        $response->assertOk();

        $response->assertJsonPath("message", 'user logged in  Succesfuly');
    }
     /**
     * A user  can't login with Wrong Email.
     *
     * @return void
     */
    public function test_a_user_cant_login_with_Wrong_email()
    {
        $creadentials = [
            "email" =>  "foulen@example.com",
            "password" =>  "password",
        ];
        User::factory()->create(["email" => "WrongEmail@example.com"]);

        $response = $this->postJson(route("user.login"), $creadentials);

        $response->assertUnauthorized();


    }
     /**
     * A user  can't login with Wrong Email.
     *
     * @return void
     */
    public function test_a_user_cant_login_with_Wrong_password()
    {
        $creadentials = [
            "email" =>  "foulen@example.com",
            "password" =>  "password",
        ];
        User::factory()->create(["password" => "WrongPaswword"]);

        $response = $this->postJson(route("user.login"), $creadentials);

        $response->assertUnauthorized();

    }
}

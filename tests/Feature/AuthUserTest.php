<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthUserTest extends TestCase
{
    use RefreshDatabase;
   /**
     * Registration test
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $data = [
            "email" => "foulen@yahoo.com",
            "name" => "foulen ben foulen",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $response = $this->postJson(route("user.register"), $data);

        $response->assertOk();

        $this->assertModelExists(User::where("email", $data["email"])->first());
        $this->assertDatabaseHas("users", [
            "email" => "foulen@yahoo.com",
            "name" => "foulen ben foulen"
        ]);
    }
    /**
     * Registration validation test
     *
     * @return void
     */
    public function test_user_cannot_register_when_input_isnt_valid()
    {
        User::factory()->create(["email" => "foulen@example.com"]);
        $data = [
            "email" => "foulen@example.com",
            "name" => "foulen",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $response = $this->postJson(route("user.register"), $data);

        $response->assertJsonValidationErrorFor("email"); //without Validator::make return an array 


        $data = [
            "email" => "foulenx@yama.com",
            "name" => "foulen",
            "password" => "password",
            "password_confirmation" => "xpassword"
        ];

        $response = $this->postJson(route("user.register"), $data);

        $response->assertJsonValidationErrorFor("password");
    }
}


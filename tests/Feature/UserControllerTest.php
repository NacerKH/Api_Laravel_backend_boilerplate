<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
       /**
     *User can change his password
     *
     * @return void
     */
    public function test_a_user_can_change_his_information_profile()
    {
    
    $profile_photo= UploadedFile::fake()->image('avatar.jpg');
     $data=[
        'name'=>"kali",
        'email'=>'email@example.com',
        'profile_photo_path'=>$profile_photo
     ];
     $user=User::factory()->create($data);//prepare data




      $this->actingAs($user);  //make authorization test ||

      $New_profile_photo=UploadedFile::fake()->image('updateimage.jpg');

      $dataToUpdate=[
        'name'=>"new Name",
        'email'=>'update@example.com',
        'profile_photo_path'=> $New_profile_photo
     ];
      $response=$this->postJson(route('user.updateProfil'),   $dataToUpdate);
      $response->assertOk();//test response

      Storage::disk('public')->assertExists('profile-photos/'.   $New_profile_photo->hashName()); //test exsit file in storage
      $user=User::find($user->id);
      #check updates data
      $this->assertNotEquals( $user->name,  $data['name']);
      $this->assertNotEquals( $user->email,  $data['email']);
      $this->assertNotEquals( $user->profile_photo_path,  $data['profile_photo_path']);


    }
}

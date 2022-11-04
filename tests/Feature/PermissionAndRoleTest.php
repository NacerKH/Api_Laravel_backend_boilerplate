<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PermissionAndRoleTest extends TestCase
{     use RefreshDatabase;
    /**
     * test_that_a_role_gets_a_permission
     *
     * @return void
     */
    public function test_that_a_role_gets_a_permission()
    {       $this->seed();
          $permission_user=Permission::where('slug','create-tasks')->first();
          $permission_admin=Permission::where('slug','edit-users')->first();
          $this->assertDatabaseHas('permissions', [
            'slug' => $permission_user->slug,
            'name' =>  $permission_user->name
        ]);
          $role_user=Role::where('slug','user')->first();
          $role_admin=Role::where('slug','admin')->first();
          $this->assertDatabaseHas('roles', [
            'slug' => $role_user->slug,
            'name' =>  $role_user->name
        ]);
        $this->assertDatabaseHas('roles', [
            'slug' =>$role_admin->slug,
            'name' =>   $role_admin->name
        ]);


        $this->assertDatabaseHas('roles_permissions', [
            'role_id' =>$role_user->id,
            'permission_id' =>  $permission_user->id
        ]);
        $this->assertDatabaseHas('roles_permissions', [
            'role_id' =>$role_admin->id,
            'permission_id' =>  $permission_admin->id
        ]);


    }
    /**
     * test_that_a_user_gets_a_role_and_permission
     *
     * @return void
     */
    public function test_that_a_user_gets_a_role_and_permission()
    {       $this->seed();
          $user=User::where("name",'Test_User')->first();
          $user_perm = Permission::where('slug','create-tasks')->first();
          $user_role = Role::where('slug','user')->first();

          $this->assertDatabaseHas('users_roles', [
            'user_id' =>  $user->id,
            'role_id' =>  $user_role->id
        ]);

        $this->assertDatabaseHas('users_permissions', [
            'user_id' =>  $user->id,
            'permission_id' =>  $user_perm->id
        ]);
        $admin=User::where("name",'Test_Admin')->first();
        $admin_perm = Permission::where('slug','edit-users')->first();
        $role_admin=Role::where('slug','admin')->first();
        $this->assertDatabaseHas('users_roles', [
            'user_id' =>  $admin->id,
            'role_id' =>  $role_admin->id
        ]);

        $this->assertDatabaseHas('users_permissions', [
            'user_id' =>  $admin->id,
            'permission_id' => $admin_perm->id
        ]);


    }
     /**
     * test_that_a_role_user_cant_access_to_role_admin
     *
     * @return void
     */
    public function test_that_a_role_user_cant_access_to_role_admin()
    {       $this->seed();
          $user=User::where("name",'Test_User')->first();
         $this->actingAs($user);
      $New_profile_photo=UploadedFile::fake()->image('updateimage.jpg');

         $dataToUpdate=[
            'name'=>"new Name",
            'email'=>'update@example.com',
            'profile_photo_path'=> $New_profile_photo
         ];
         $response=$this->postJson(route('admin.updateProfil'), $dataToUpdate);
         $response->assertUnauthorized();

        


    }



}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Role::create(["name"=>"User_Name","slug" => "user"]);
        Role::create(["name"=>"Admin_Name","slug" => "admin"]);

        $user_permission = Permission::where('slug','create-tasks')->first();
		$admin_permission = Permission::where('slug', 'edit-users')->first();
        $user_role=Role::where('slug','user')->first();
        $user_role->permissions()->attach($user_permission);
        $admin_role=Role::where('slug','admin')->first();
        $admin_role->permissions()->attach($admin_permission);

        $createTasks = Permission::create(["name"=> 'Create Tasks',"slug" => 'create-tasks']);
        $createTasks->roles()->attach($user_role);

		$editUsers = Permission::create(["name"=> 'Edit Users',"slug" => 'edit-users']);
        $editUsers->roles()->attach($admin_role);

		$user_role = Role::where('slug','user')->first();
		$admin_role = Role::where('slug', 'admin')->first();
		$user_perm = Permission::where('slug','create-tasks')->first();
		$admin_perm = Permission::where('slug','edit-users')->first();

		$user = User::create(["name"=>'Test_User',"email" =>'test_user@gmail.com',"password" => bcrypt('1234567')]);
        $user->roles()->attach($user_role);
		$user->permissions()->attach($user_perm);
        $admin =  User::create(["name"=>'Test_Admin',"email" =>'test_admin@gmail.com',"password" =>bcrypt('admin1234')]);
        $admin->roles()->attach($admin_role);
		$admin->permissions()->attach($admin_perm);

    }
}

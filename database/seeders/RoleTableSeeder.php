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

        $data = [
            [
                "name"=>"User_Name",
                "slug" => "user",

            ],
            [
                "name"=>"Admin_Name",
                "slug" => "admin",

            ]
            ];
        Role::insert($data);

        $user_permission = Permission::where('slug','create-tasks')->first();
		$admin_permission = Permission::where('slug', 'edit-users')->first();
        $user_role=Role::where('slug','user')->first();
        $user_role->permissions()->attach($user_permission);
        $admin_role=Role::where('slug','admin')->first();
        $admin_role->permissions()->attach($admin_permission);

        $createTasks = new Permission();
		$createTasks->slug = 'create-tasks';
		$createTasks->name = 'Create Tasks';
		$createTasks->save();
		$createTasks->roles()->attach($user_role);

		$editUsers = new Permission();
		$editUsers->slug = 'edit-users';
		$editUsers->name = 'Edit Users';
		$editUsers->save();
		$editUsers->roles()->attach($admin_role);

		$user_role = Role::where('slug','user')->first();
		$admin_role = Role::where('slug', 'admin')->first();
		$user_perm = Permission::where('slug','create-tasks')->first();
		$admin_perm = Permission::where('slug','edit-users')->first();

		$user = new User();
		$user->name = 'Test_User';
		$user->email = 'test_user@gmail.com';
		$user->password = bcrypt('1234567');
		$user->save();
		$user->roles()->attach($user_role);
		$user->permissions()->attach($user_perm);

		$admin = new User();
		$admin->name = 'Test_Admin';
		$admin->email = 'test_admin@gmail.com';
		$admin->password = bcrypt('admin1234');
		$admin->save();
		$admin->roles()->attach($admin_role);
		$admin->permissions()->attach($admin_perm);

    }
}

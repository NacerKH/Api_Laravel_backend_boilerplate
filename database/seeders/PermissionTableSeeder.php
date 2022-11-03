<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
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
                "name"=>"create task",
                "slug" => "create-tasks",

            ],
            [
                "name"=>"delete task",
                "slug" => "delete-tasks",

            ], [
                "name"=>"edit task",
                "slug" => "edit-tasks",

            ],
            [
                "name"=>"create users",
                "slug" => "create-users",

            ],
            [
                "name"=>"delete users",
                "slug" => "delete-users",

            ], [
                "name"=>"edit users",
                "slug" => "edit-users",

            ]
 ];



            Permission::insert($data);
        }
    }


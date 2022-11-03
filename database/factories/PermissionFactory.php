<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {      $name= array( "create", "edit", "delete", "update" );
            $slug = array( "create-tasks", "edit-tasks", "delete-tasks", "update-tasks" );
            $Randname = array_rand($name);
            $Randslug= array_rand($slug);
            return [
         'name'=>$name[$Randname],
         'slug'=> $slug[$Randslug],

        ];
    }
}

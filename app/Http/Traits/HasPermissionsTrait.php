<?php

namespace App\Http\Traits;

use App\Models\Permission;
use App\Models\User;
use App\Models\Role;

trait HasPermissionsTrait {

    /**
     * PHP has support for variable-length argument lists in user-defined functions by using the ...
     *Argument lists may include the ...   to denote that the function accepts a variable number of arguments.
     *The arguments will be passed into the given variable as an array.
     * https://www.php.net/manual/en/functions.arguments.php#functions.variable-arg-list
     */
    public function givePermissionsTo(... $permissions) {

        $permissions = $this->getAllPermissions($permissions);

        if($permissions === null) {
          return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
      }

      public function withdrawPermissionsTo( ... $permissions ) {

        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;

      }

      public function refreshPermissions( ... $permissions ) {

        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
      }

      public function hasPermissionTo($permission) {

        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
      }

      public function hasPermissionThroughRole($permission) {

        foreach ($permission->roles as $role){
          if($this->roles->contains($role)) {
            return true;
          }
        }
        return false;
      }

      public function hasRole( ... $roles ) {

        foreach ($roles as $role) {
          if ($this->roles->contains('slug', $role)) {
            return true;
          }
        }
        return false;
      }

      public function roles() {

        return $this->belongsToMany(Role::class,'users_roles');

      }
      public function permissions() {

        return $this->belongsToMany(Permission::class,'users_permissions');

      }
      protected function hasPermission($permission) {

        return (bool) $this->permissions->where('slug', $permission->slug)->count();
      }

      protected function getAllPermissions(array $permissions) {

        return Permission::whereIn('slug',$permissions)->get();

      }

}

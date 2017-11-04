<?php

namespace App\Http\Controllers\Client\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ViewController extends Controller
{
    public function matrix()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $role_permissions = array();
        foreach ($roles as $role) {
            $granted_permission = array();
            foreach ($role->permissions as $permission) {
                array_push($granted_permission, ['id' => $permission->id, 'name' => $permission->name]);
            }
            array_push($role_permissions, ['role_id'=>$role->id,'role' => $role->name, 'permission' => $granted_permission]);
        }

        return view('pages.permission.role_permission', compact('role_permissions'));
    }
}

<?php

namespace App\Http\Controllers\Client\Settings\Permission;

use App\Account\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ViewController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::all();
        return view('pages.permission.roles_permissions', compact('permissions','roles','users'));
    }

}

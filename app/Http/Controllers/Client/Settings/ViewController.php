<?php

namespace App\Http\Controllers\Client\Settings;

use App\Account\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ViewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['permission:view setting']);
    }

    public function passport()
    {
        return view('pages.settings.passport');
    }

    public function permission()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        $users = User::all();
        return view('pages.settings.permission', compact('permissions','roles','users'));
    }

    public function notification()
    {
        return view('pages.settings.notification');
    }


}

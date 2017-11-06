<?php

namespace App\Http\Controllers\BackendV1\Settings\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class MainController extends Controller
{
    public function createRole(Request $request)
    {
        $request->validate(['name' => 'required|regex:/^[\pL\s\-]+$/u|unique:roles']);
        $name = $request->get('name');

        Role::create(['name'=>$name]);

        $request->session()->flash('alert-info','New role: '. $name . ' has been created successfully ');
        return redirect()->route('setting.permission');
    }

    public function createPermission(Request $request)
    {
        $request->validate(['name' => 'required|regex:/^[\pL\s\-]+$/u|unique:permissions']);

        $name = strtolower($request->get('name')); // change to lowercase
        Permission::create(['name'=>$name]);

        $request->session()->flash('alert-info','New permission: '. $name . ' has been created successfully ');
        return redirect()->route('setting.permission');

    }
}

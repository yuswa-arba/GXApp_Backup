<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Settings\Permission;

use App\Permission\Transformers\PermissionTransformer;
use App\Permission\Transformers\RoleTransformer;
use App\Permission\Transformers\VdByPermissionTransformer;
use App\Permission\Transformers\VdByRoleTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AjaxController extends Controller
{
    public function vdByPermission($permissionName)
    {
        if ($permissionName == "" || $permissionName == null) {
            return response()->json(['message' => 'parameter permissionName is empty or null'], 500);
        }

        $permission = Permission::findByName($permissionName);

        return fractal($permission, new VdByPermissionTransformer())->includeAllRoles()->includeAssignedRoles()->respond(200);

    }


    public function assignByPermission(Request $request)
    {
        $request->validate(['permissionName' => 'required']);

        $permissionName = $request->permissionName;
        $assignRoleIdArr = $request->assignRoleIdArr;
        $assignUserArr = $request->assignUserArr;

        if ($assignRoleIdArr != null && $assignRoleIdArr != '') {
            /* Assign permission to Roles */
            $assignRoles = Role::whereIn('id', $assignRoleIdArr)->get();

            foreach ($assignRoles as $assignRole) {

                if (!$assignRole->hasPermissionTo($permissionName)) {
                    $assignRole->givePermissionTo($permissionName);
                }

            }

            /* Revoke permission from Roles*/
            $revokeRoles = Role::whereNotIn('id', $assignRoleIdArr)->get();
            foreach ($revokeRoles as $revokeRole) {
                $revokeRole->revokePermissionTo($permissionName);
            }

        } else {

            /* If assign roles are empty then revoke all*/
            $roles = Role::all();
            foreach ($roles as $role) {
                $role->revokePermissionTo($permissionName);
            }
        }

        /* TODO : assign and revoke by USERS */


        return response([
            'message' => 'Assign permission successful',
            'assigned' => fractal(Role::whereIn('id',$assignRoleIdArr)->get(),new RoleTransformer())

        ],200);
    }


    public function vdByRole($roleName)
    {

        if ($roleName == "" || $roleName == null) {
            return response()->json(['message' => 'parameter roleName is empty or null'], 500);
        }

        $role = Role::findByName($roleName);
        return fractal($role, new VdByRoleTransformer())->includeAllPermissions()->includeAssignedPermissions()->respond(200);

    }

    public function assignByRole(Request $request)
    {
        $request->validate(['roleName' => 'required']);

        $roleName = $request->roleName;
        $role = Role::findByName($roleName);

        $assignPermissionIdArr = $request->assignPermissionIdArr;

        if ($role == null) {
            return response(['message' => 'Role is empty'], 500);
        }

        if ($assignPermissionIdArr != null && $assignPermissionIdArr != '') {

            /* Assign permission for this Role */
            $assignPermissions = Permission::whereIn('id', $assignPermissionIdArr)->get();
            foreach ($assignPermissions as $assignPermission) {
                if (!$role->hasPermissionTo($assignPermission->name)) {
                    $role->givePermissionTo($assignPermission->name);
                }
            }

            /* Revoke permission from this Role*/
            $revokePermissions = Permission::whereNotIn('id', $assignPermissionIdArr)->get();
            foreach ($revokePermissions as $revokePermission) {
                $role->revokePermissionTo($revokePermission->name);
            }
        } else {

            $role->syncPermissions(); // revoke all permission
        }

        return response([
            'message' => 'Assign permission successful',
            'assigned' => fractal(Permission::whereIn('id',$assignPermissionIdArr)->get(),new PermissionTransformer())
        ], 200);
    }



}

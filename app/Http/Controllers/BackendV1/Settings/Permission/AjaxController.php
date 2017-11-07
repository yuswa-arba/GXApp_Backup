<?php

namespace App\Http\Controllers\BackendV1\Settings\Permission;

use App\Permission\Transformers\AssignedPermissionTransformer;
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

        return fractal($permission, new AssignedPermissionTransformer())->includeAllRoles()->includeAssignedRoles()->respond(200);

    }


    public function assignByPermission(Request $request)
    {
        $request->validate(['permissionName' => 'required']);

        $permissionName = $request->permissionName;
        $assignRoleArr = $request->assignRoleArr;
        $assignUserArr = $request->assignUserArr;

        /* Assign permission to Roles */
        $assignRoles = Role::whereIn('id', $assignRoleArr)->get();
        foreach ($assignRoles as $assignRole) {

            if (!$assignRole->hasPermissionTo($permissionName)){
                $assignRole->givePermissionTo($permissionName);
            }

        }

        /* Revoke permission from Roles*/
        $revokeRoles = Role::whereNotIn('id', $assignRoleArr)->get();
        foreach ($revokeRoles as $revokeRole) {
            $revokeRole->revokePermissionTo($permissionName);
        }

        /* TODO: give and revoke permission to/from users */

        return response(['message' => 'Assign permission successful', 200]);

    }


}

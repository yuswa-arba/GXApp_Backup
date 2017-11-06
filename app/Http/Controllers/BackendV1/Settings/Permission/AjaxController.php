<?php

namespace App\Http\Controllers\BackendV1\Settings\Permission;

use App\Permission\Transformers\AssignedPermissionTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class AjaxController extends Controller
{
    public function vdByPermission($permissionName)
    {
        if ($permissionName == "" || $permissionName == null) {
            return response()->json(['message'=>'parameter permissionName is empty or null'],500);
        }

        $permission = Permission::findByName($permissionName);

        return fractal($permission,new AssignedPermissionTransformer())->includeAssignedRoles()->respond(200);

    }
}

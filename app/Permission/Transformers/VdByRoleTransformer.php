<?php
namespace App\Permission\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 8:35 PM
 */
class VdByRoleTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
//        'assignedUsers',
        'assignedPermissions',
        'allPermissions'
    ];

    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }

    public function includeAllPermissions(Role $role)
    {
        $permissions = Permission::all();
        return $this->collection($permissions, new PermissionTransformer, 'permissions');
    }

    public function includeAssignedPermissions(Role $role)
    {
        $permissions = $role->permissions;
        return $this->collection($permissions, new PermissionTransformer, 'permissions');
    }
}
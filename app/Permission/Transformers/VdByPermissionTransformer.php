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
class VdByPermissionTransformer extends TransformerAbstract
{
    protected $defaultIncludes=[
//        'assignedUsers',
        'assignedRoles',
        'allRoles'
    ];

    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name'=>$permission->name,
        ];
    }


    public function includeAllRoles(Permission $permission)
    {
        $roles =Role::all();
        return $this->collection($roles,new RoleTransformer,'roles');
    }

    public function includeAssignedRoles(Permission $permission)
    {
        $roles = $permission->roles;
        return $this->collection($roles,new RoleTransformer,'roles');
    }


//    public function includeAssignedUsers(Permission $permission)
//    {
//
//    }


}
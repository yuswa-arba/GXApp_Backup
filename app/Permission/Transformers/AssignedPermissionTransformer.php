<?php
namespace App\Permission\Transformers;
use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 8:35 PM
 */
class AssignedPermissionTransformer extends TransformerAbstract
{
    protected $defaultIncludes=[
//        'assignedUsers',
        'assignedRoles'
    ];

    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name'=>$permission->name,
        ];
    }

//    public function includeAssignedUsers(Permission $permission)
//    {
//
//    }

    public function includeAssignedRoles(Permission $permission)
    {
        $roles = $permission->roles;
        return $this->collection($roles,new RoleTransformer,'roles');
    }
}
<?php
namespace App\Permission\Transformers;

use App\Account\Models\User;
use League\Fractal\TransformerAbstract;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 6/11/17
 * Time: 8:35 PM
 */
class VdByUserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
//        'assignedUsers',
        'assignedRoles',
        'allRoles'
    ];

    public function transform(User $user)
    {
        return [
            'employeeId' => $user->employeeId,
            'name' => !is_null($user->employee)?$user->employee->givenName .' '.$user->employee->surname:'',
        ];
    }

    public function includeAllRoles(User $user)
    {
        $roles = Role::all();
        return $this->collection($roles, new RoleTransformer, 'roles');
    }

    public function includeAssignedRoles(User $user)
    {
        $roles = $user->roles;
        return $this->collection($roles, new RoleTransformer, 'roles');
    }
}
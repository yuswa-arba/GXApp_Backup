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
class UserListTransformer extends TransformerAbstract
{
    protected $defaultIncludes=[

    ];

    public function transform(User $user)
    {
        $totalPermission = count(Permission::all());
        $totalRoles = count(Role::all());

        return [
            'employeeId' => $user->employeeId,
            'name'=>!is_null($user->employee)?$user->employee->givenName .' '.$user->employee->surname :'',
            'permissions'=>$user->permissions,
            'roles'=>$user->roles,
            'totalPermission'=>$totalPermission,
            'totalRoles'=>$totalRoles
        ];
    }



   
}
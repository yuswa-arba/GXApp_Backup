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
class PermissionListTransformer extends TransformerAbstract
{
    protected $defaultIncludes=[

    ];

    public function transform(Permission $permission)
    {
        $totalRole = count(Role::all());
        $totalUser = count(User::all());
        return [
            'id' => $permission->id,
            'name'=>$permission->name,
            'roles'=>$permission->roles,
            'users'=>$permission->users,
            'totalRole'=>$totalRole,
            'totalUser'=>$totalUser
        ];
    }



   
}
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
class RoleTransformer extends TransformerAbstract
{
    protected $defaultIncludes=[];

    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'name'=>$role->name,
        ];
    }
}
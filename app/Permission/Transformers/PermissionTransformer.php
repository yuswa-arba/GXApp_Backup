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
class PermissionTransformer extends TransformerAbstract
{
    protected $defaultIncludes=[];

    public function transform(Permission $permission)
    {
        return [
            'id' => $permission->id,
            'name'=>$permission->name,
        ];
    }
}
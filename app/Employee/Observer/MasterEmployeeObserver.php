<?php
use App\Employee\Models\MasterEmployee;
use App\Traits\GlobalUtils;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 3/11/17
 * Time: 1:29 PM
 */
class MasterEmployeeObserver
{
    use GlobalUtils;

    public function creating(MasterEmployee $model)
    {
        /* Insert UUID in id column*/
        $model->{$model->getKeyName()} = $this->generateUUID();
    }
}
<?php

namespace App\Components\Models;

use App\Employee\Models\HeadOfDivison;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
    protected $guarded = ['id'];


    public function manager()
    {
        return $this->hasOne(DivisionManager::class,'divisionId');
    }

}

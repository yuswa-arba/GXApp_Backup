<?php

namespace App\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    protected $table = 'employment';
    protected $guarded= ['id','employeeId'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId','id');
    }

}

<?php

namespace App\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    protected $table = 'resignation';
    protected $guarded= ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

}

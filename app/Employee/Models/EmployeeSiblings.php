<?php

namespace App\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSiblings extends Model
{
    protected $table = 'employeeSiblings';
    protected $guarded= ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

}

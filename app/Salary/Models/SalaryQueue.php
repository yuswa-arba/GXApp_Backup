<?php

namespace App\Salary\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class SalaryQueue extends Model
{
    protected $table='salaryQueue';
    protected $guarded =['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function salaryBonusCutType()
    {
        return $this->belongsTo(SalaryBonusCutType::class,'salaryBonusCutTypeId');
    }

}

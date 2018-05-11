<?php

namespace App\Salary\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class EmployeeBonusesCuts extends Model
{
    protected $table = 'employeeBonusesCuts';
    protected $guarded= ['id'];

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function salaryBonusCutType()
    {
        return $this->belongsTo(SalaryBonusCutType::class,'salaryBonusCutTypeId');
    }

}

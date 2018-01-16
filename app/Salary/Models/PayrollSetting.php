<?php

namespace App\Salary\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollSetting extends Model
{
    protected $table='payrollSetting';
    protected $guarded= ['id'];

    public function employeeBonusesCuts()
    {
        return $this->hasMany(EmployeeBonusesCuts::class,'salaryBonusCutTypeId');
    }

    public function generalBonusesCuts()
    {
        return $this->hasMany(GeneralBonusesCuts::class,'salaryBonusCutTypeId');
    }
}

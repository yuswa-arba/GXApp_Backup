<?php

namespace App\Salary\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryBonusCutType extends Model
{
    protected $table= 'salaryBonusCutType';
    protected $guarded = ['id'];


    public function employeeBonusesCuts()
    {
        return $this->hasMany(EmployeeBonusesCuts::class,'salaryBonusCutTypeId');
    }


    public function generalBonusesCuts()
    {
        return $this->hasMany(GeneralBonusesCuts::class,'salaryBonusCutTypeId');
    }


}

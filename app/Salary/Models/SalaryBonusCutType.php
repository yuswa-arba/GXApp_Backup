<?php

namespace App\Salary\Models;

use App\Components\Models\Division;
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

    public function division()
    {
        return $this->belongsTo(Division::class,'divisionId');
    }


}

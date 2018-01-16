<?php

namespace App\Salary\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class SalaryCalculation extends Model
{
    protected $table='salaryCalculation';
    protected $guarded=['id'];


    public function salaryReport()
    {
        return $this->belongsTo(SalaryReport::class,'salaryReportId');
    }

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function salaryBonusCutType()
    {
        return $this->belongsTo(SalaryBonusCutType::class,'salaryBonusCutTypeId');
    }

}

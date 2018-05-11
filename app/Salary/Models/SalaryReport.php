<?php

namespace App\Salary\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class SalaryReport extends Model
{
    protected $table='salaryReport';
    protected $guarded=['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function generatedPayroll()
    {
        return $this->belongsTo(GeneratePayroll::class,'generatePayrollId');
    }

    public function confirmationStatus()
    {
        return $this->belongsTo(SalaryReportConfirmationStatus::class,'confirmationStatusId');
    }

}

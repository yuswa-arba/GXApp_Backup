<?php

namespace App\Salary\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class SalaryReportConfirmationStatus extends Model
{
    protected $table='salaryReportConfirmationStatus';
    protected $guarded=['id'];

    public function salaryReport()
    {
        return $this->hasMany(SalaryReport::class,'confirmationStatusId');
    }

}

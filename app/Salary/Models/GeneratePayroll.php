<?php

namespace App\Salary\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class GeneratePayroll extends Model
{
    protected $table=  'generatePayroll';
    protected $guarded = ['id'];

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branchOfficeId');
    }

    public function generateSalaryReportLog()
    {
        return $this->belongsTo(GenerateSalaryReportLogs::class,'salaryReportLogId');
    }

}

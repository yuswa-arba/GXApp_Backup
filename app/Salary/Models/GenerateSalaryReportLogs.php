<?php

namespace App\Salary\Models;

use App\Components\Models\BranchOffice;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class GenerateSalaryReportLogs extends Model
{
    protected $table='generateSalaryReportLog';
    protected $guarded=['id'];

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branchOfficeId');
    }

}

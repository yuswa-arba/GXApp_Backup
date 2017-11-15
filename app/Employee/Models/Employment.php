<?php

namespace App\Employee\Models;

use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    protected $table = 'employment';
    protected $guarded= ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branchOfficeId');
    }

    public function division()
    {
        return $this->belongsTo(Division::class,'divisionId');
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class,'jobPositionId');
    }

    public function recruitmentStatus()
    {
        return $this->belongsTo(RecruitmentStatus::class,'recruitmentStatusId');
    }

}

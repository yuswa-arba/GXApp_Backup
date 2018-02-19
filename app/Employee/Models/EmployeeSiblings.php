<?php

namespace App\Employee\Models;

use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use Illuminate\Database\Eloquent\Model;

class EmployeeSiblings extends Model
{
    protected $table = 'employeeSiblings';
    protected $guarded= ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

}

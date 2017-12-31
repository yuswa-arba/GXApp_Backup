<?php

namespace App\Employee\Models;

use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use Illuminate\Database\Eloquent\Model;

class HeadOfDivison extends Model
{
    protected $table = 'headOfDivision';
    protected $guarded= ['id'];


    public function division()
    {
        return $this->belongsTo(Division::class,'divisionId');
    }

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

}

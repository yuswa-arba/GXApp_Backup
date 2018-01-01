<?php

namespace App\Components\Models;

use App\Employee\Models\HeadOfDivison;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class DivisionManager extends Model
{
    protected $table = 'divisionManager';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function division()
    {
        return $this->belongsTo(Division::class,'divisionId');
    }

}

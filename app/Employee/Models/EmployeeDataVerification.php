<?php

namespace App\Employee\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDataVerification extends Model
{
    protected $table = 'employeeDataVerification';
    protected $guarded = ['id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId','id');
    }
}

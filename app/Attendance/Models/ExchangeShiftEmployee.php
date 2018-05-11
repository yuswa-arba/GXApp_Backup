<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class ExchangeShiftEmployee extends Model
{
    protected $table='exchangeShiftEmployee';
    protected $guarded=['id'];

    public function requesterEmployee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId1');
    }

    public function ownerEmployee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId2');
    }

    public function fromShift()
    {
        return $this->belongsTo(Shifts::class,'fromShiftId');
    }

    public function toShift()
    {
        return $this->belongsTo(Shifts::class,'toShiftId');
    }

}

<?php

namespace App\Attendance\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class ExchangeSlotEmployee extends Model
{
    protected $table='exchangeSlotEmployee';
    protected $fillable=[
        'employeeId1',
        'fromSlotId',
        'employeeId2',
        'toSlotId',
        'fromDates',
        'toDates',
        'slotApproveId',
        'approvedBy',
    ];

    public function firstEmployee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId1');
    }

    public function secondEmployee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId2');
    }

    public function fromSlot()
    {
        return $this->belongsTo(Slots::class,'fromSlotId');
    }

    public function toSlot()
    {
        return $this->belongsTo(Slots::class,'toSlotId');
    }
}

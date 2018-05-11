<?php

namespace App\Attendance\Models;

use App\Components\Models\Religion;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class PublicHolidaySchedule extends Model
{
    protected $table='publicHolidaySchedule';
    protected $guarded =['id'];

    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function publicHoliday()
    {
        return $this->belongsTo(PublicHoliday::class,'pubHolidayId');
    }

    public function slot()
    {
        return $this->belongsTo(Slots::class,'fromSlotId');
    }

}

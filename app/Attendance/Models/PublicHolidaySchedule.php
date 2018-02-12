<?php

namespace App\Attendance\Models;

use App\Components\Models\Religion;
use Illuminate\Database\Eloquent\Model;

class PublicHolidaySchedule extends Model
{
    protected $table='publicHolidaySchedule';
    protected $fillable =[
        'date',
        'name',
        'isGeneral',
        'religionId',
    ];

    public function religion()
    {
        return $this->belongsTo(Religion::class,'religionId');
    }

}

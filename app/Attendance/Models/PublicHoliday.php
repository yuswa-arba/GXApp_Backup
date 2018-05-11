<?php

namespace App\Attendance\Models;

use App\Components\Models\Religion;
use Illuminate\Database\Eloquent\Model;

class PublicHoliday extends Model
{
    protected $table='publicHoliday';
    protected $guarded =['id'];

    public function religion()
    {
        return $this->belongsTo(Religion::class,'religionId');
    }

}

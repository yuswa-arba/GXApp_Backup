<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class KioskActivity extends Model
{
    protected $table = 'kioskActivity';
    protected $guarded = [];

    public function kiosk()
    {
        return $this->belongsTo(Kiosks::class,'kioskId');
    }
}

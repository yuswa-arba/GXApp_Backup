<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Kiosks extends Model
{
    protected $table = 'kiosks';
    protected $guarded = [];

    public function kioskActivity()
    {
        return $this->hasOne(KioskActivity::class,'kioskId');
    }
}

<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Kiosks extends Model
{
    protected $table = 'kiosks';
    protected $guarded = [];

    // you still can retrieve those hidden fields by using $kiosk['apiToken']
    protected $hidden=['passcode','activationCode','apiToken','created_at','updated_at'];


    public function kioskActivity()
    {
        return $this->hasOne(KioskActivity::class,'kioskId');
    }
}

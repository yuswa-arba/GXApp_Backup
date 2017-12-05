<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Kiosks extends Model
{
    protected $table='kiosks';
    protected $fillable = [
        'description',
        'api_token',
        'batteryPower',
        'isCharging',
        'isEnabled',
    ];
}

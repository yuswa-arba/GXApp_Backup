<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    protected $table='shifts';
    protected $fillable=[
        'name',
        'workStartAt',
        'workEndAt',
        'breakStartAt',
        'breakEndAt',
        'isOvernight',
    ];
}

<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table='leaveType';
    protected $fillable=['name'];
}

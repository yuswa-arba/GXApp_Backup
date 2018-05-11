<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApproval extends Model
{
    protected $table='leaveApproval';
    protected $fillable=['name'];
}

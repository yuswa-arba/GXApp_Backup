<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class SlotApproval extends Model
{
    protected $table = 'slotApproval';
    protected $fillable = [
        'name'
    ];
}

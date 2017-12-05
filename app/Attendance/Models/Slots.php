<?php

namespace App\Attendance\Models;

use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    protected $table='slots';
    protected $fillable = [
        'name',
        'slotMakerId',
    ];

    public function slotMaker()
    {
        return $this->belongsTo(SlotMaker::class,'slotMakerId');
    }
}

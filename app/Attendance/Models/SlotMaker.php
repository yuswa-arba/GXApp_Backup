<?php

namespace App\Attendance\Models;

use App\Components\Models\JobPosition;
use Illuminate\Database\Eloquent\Model;

class SlotMaker extends Model
{
    protected $table = 'slotMaker';
    protected $fillable = [
        'name',
        'firstDate',
        'relatedToJobPosition',
        'jobPositionId',
        'totalDayLoop',
        'workingDays',
        'allowMultipleAssign',
        'isExecuted',
        'executedAt',
        'executedBy',
    ];

    protected $casts = [
        'allowMultipleAssign' => 'boolean'
    ];


    public function slot()
    {
        return $this->hasMany(Slots::class, 'slotMakerId');
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class, 'jobPositionId');
    }


}

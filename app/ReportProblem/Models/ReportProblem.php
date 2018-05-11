<?php

namespace App\ReportProblem\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProblem extends Model
{
    protected $table = 'reportProblem';
    protected $guarded = ['id'];

    public function problemType()
    {
        return $this->belongsTo(ReportProblemType::class,'typeId');
    }

}

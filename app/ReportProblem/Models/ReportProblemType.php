<?php

namespace App\ReportProblem\Models;

use Illuminate\Database\Eloquent\Model;

class ReportProblemType extends Model
{
    protected $table = 'reportProblemType';
    protected $guarded = ['id'];

    public function reportProblem()
    {
        return $this->hasMany(ReportProblem::class,'typeId');
    }

}

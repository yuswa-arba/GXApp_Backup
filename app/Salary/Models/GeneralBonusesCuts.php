<?php

namespace App\Salary\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralBonusesCuts extends Model
{
    protected $table  = 'generalBonusesCuts';
    protected $guarded = ['id'];


    public function salaryBonusCutType()
    {
        return $this->belongsTo(SalaryBonusCutType::class,'salaryBonusCutTypeId');
    }

}

<?php

namespace App\Components\Models;

use App\Employee\Models\HeadOfDivison;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'divisions';
    protected $guarded = ['id'];


    public function headOfDvision()
    {
        return $this->hasMany(HeadOfDivison::class,'divisionId');
    }

}

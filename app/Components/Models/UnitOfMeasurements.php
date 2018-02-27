<?php

namespace App\Components\Models;

use Illuminate\Database\Eloquent\Model;

class UnitOfMeasurements extends Model
{
    protected $table = 'unitOfMeasurements';
    protected $guarded = ['id'];

    public function uomType()
    {
     return $this->belongsTo(UnitOfMeasurementType::class,'unitOfMeasurementTypeId');
    }
}

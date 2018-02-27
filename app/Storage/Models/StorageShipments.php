<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\ShippingTypes;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageShipments extends Model
{
    protected $table = 'storageShipments';
    protected $guarded = ['id'];


    public function shippingType()
    {
        return $this->belongsTo(ShippingTypes::class, 'shippingTypeId');
    }


}

<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\UnitOfMeasurements;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageItems extends Model
{
    protected $table = 'storageItems';
    protected $guarded = ['id'];


    public function unitOfMeasurement()
    {
        return $this->belongsTo(UnitOfMeasurements::class,'unitId');
    }


    public function itemCategory()
    {
        return $this->belongsTo(StorageItemsCategory::class,'categoryCode');
    }

    public function itemStatus()
    {
        return $this->belongsTo(StorageItemStatus::class,'statusId');
    }

}

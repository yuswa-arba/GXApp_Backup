<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\UnitOfMeasurements;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StoragePurchaseOrderItems extends Model
{
    protected $table = 'storagePurchaseOrderItems';
    protected $guarded = ['id'];

    public function purchaseOrder()
    {
        return $this->belongsTo(StoragePurchaseOrders::class,'purchaseOrderId');
    }

    public function itemTrack()
    {
        return $this->hasOne(StoragePurchaseOrderItemTrack::class,'purchaseOrderItemId');
    }


}

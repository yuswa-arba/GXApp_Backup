<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\ShippingTypes;
use App\Components\Models\UnitOfMeasurements;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StoragePurchaseOrderItemTrack extends Model
{
    protected $table = 'storagePurchaseOrderItemTrack';
    protected $guarded = ['id'];

    public function purchaseOrderItem()
    {
        return $this->belongsTo(StoragePurchaseOrderItems::class,'purchaseOrderItemId');
    }

    public function shippingType()
    {
        return $this->belongsTo(ShippingTypes::class,'shippingTypeId');
    }

    public function actionType()
    {
        
    }

    public function storageWarehouse()
    {
        return $this->belongsTo(StorageWarehouses::class,'deliveryWarehouseId');
    }


}

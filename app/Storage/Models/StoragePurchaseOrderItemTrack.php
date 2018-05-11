<?php

namespace App\Storage\Models;

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


    public function actionType()
    {
        
    }

    public function storageWarehouse()
    {
        return $this->belongsTo(StorageWarehouses::class,'deliveryWarehouseId');
    }


}

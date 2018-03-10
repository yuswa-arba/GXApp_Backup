<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\UnitOfMeasurements;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StoragePurchaseOrders extends Model
{
    protected $table = 'storagePurchaseOrders';
    protected $guarded = ['id'];


    public function purchaseOrderItems()
    {
        return $this->hasMany(StoragePurchaseOrderItems::class,'purchaseOrderId');
    }

    public function supplier()
    {
        return $this->belongsTo(StorageSuppliers::class,'supplierId');
    }


    public function warehouse()
    {
        return $this->belongsTo(StorageWarehouses::class,'warehouseId');
    }

    public function requisition()
    {
        return $this->belongsTo(StorageRequisition::class,'requisitionId');
    }

    public function status()
    {
     return $this->belongsTo(StoragePurchaseOrderStatus::class,'statusId');
    }

}

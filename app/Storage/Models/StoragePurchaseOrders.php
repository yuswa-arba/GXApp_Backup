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


    public function purchaseOrerItems()
    {
        return $this->hasMany(StoragePurchaseOrderItems::class,'purchaseOrderId');
    }

    public function supplier()
    {

    }


}

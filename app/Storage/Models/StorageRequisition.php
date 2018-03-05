<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageRequisition extends Model
{
    protected $table = 'storageRequisition';
    protected $guarded = ['id'];


    public function division()
    {
        return $this->belongsTo(Division::class,'divisionId');
    }

    public function requesterEmployee()
    {
        return $this->belongsTo(MasterEmployee::class,'requesterEmployeeId');
    }

    public function approval()
    {
        return $this->belongsTo(StorageRequisitionApproval::class,'approvalId');
    }

    public function requisitionItems()
    {
        return $this->hasMany(StorageRequisitionItems::class,'requisitionNumber','requisitionNumber');
    }

    public function storageWarehouse()
    {
        return $this->belongsTo(StorageWarehouses::class,'deliveryWarehouseId');
    }

}

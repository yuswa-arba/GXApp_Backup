<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageRequisitionItems extends Model
{
    protected $table = 'storageRequisitionItems';
    protected $guarded = ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

    public function item()
    {
        return $this->belongsTo(StorageItems::class,'itemId');
    }

    public function requisition()
    {
        return $this->belongsTo(StorageRequisition::class,'requisitionNumber','requisitionNumber');
    }
    
}

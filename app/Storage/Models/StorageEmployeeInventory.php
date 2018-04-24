<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageEmployeeInventory extends Model
{
    protected $table = 'storageEmployeeInventory';
    protected $guarded = ['id'];


    public function inventoryItem()
    {
        return $this->belongsTo(StorageInventoryItem::class,'inventoryItemId');
    }


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

}

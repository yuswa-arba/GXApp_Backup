<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageSalesInventory extends Model
{
    protected $table = 'storageSalesInventory';
    protected $guarded = ['id'];

    public function inventoryItem()
    {
        return $this->belongsTo(StorageInventoryItem::class,'inventoryItemId');
    }

}

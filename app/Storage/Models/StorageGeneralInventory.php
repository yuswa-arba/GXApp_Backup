<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageGeneralInventory extends Model
{
    protected $table = 'storageGeneralInventory';
    protected $guarded = ['id'];


    public function inventoryItem()
    {
        return $this->belongsTo(StorageInventoryItem::class,'inventoryItemId');
    }

    public function testStatus()
    {
        return $this->belongsTo(StorageItemTestStatus::class,'testStatusId');
    }

}

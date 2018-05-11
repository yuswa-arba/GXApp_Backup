<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageTestingInventory extends Model
{
    protected $table = 'storageTestingInventory';
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

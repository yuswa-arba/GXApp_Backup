<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageInventoryItem extends Model
{
    protected $table = 'storageInventoryItemHistory';
    protected $guarded = ['id'];


    public function inventoryItem()
    {
        return $this->belongsTo(StorageInventoryItem::class,'inventoryItemId');
    }

}

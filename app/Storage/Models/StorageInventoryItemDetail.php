<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageInventoryItemDetail extends Model
{
    protected $table = 'storageInventoryItemDetail';
    protected $guarded = ['id'];


    public function inventoryItem()
    {
        return $this->belongsTo(StorageInventoryItem::class,'inventoryItemId');
    }

    public function inventoryType()
    {
        //
    }

}

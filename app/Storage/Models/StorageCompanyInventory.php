<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageCompanyInventory extends Model
{
    protected $table = 'storageCompanyInventory';
    protected $guarded = ['id'];


    public function inventoryItem()
    {
        return $this->belongsTo(StorageInventoryItem::class,'inventoryItemId');
    }


    public function companyRoom()
    {
        return $this->belongsTo(StorageCompanyRoom::class,'companyRoomId');
    }

}

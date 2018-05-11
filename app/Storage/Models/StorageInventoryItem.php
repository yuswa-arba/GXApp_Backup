<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageInventoryItem extends Model
{
    protected $table = 'storageInventoryItem';
    protected $guarded = ['id'];


    public function item()
    {
        return $this->belongsTo(StorageItems::class,'itemId');
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branchOfficeId');
    }

}

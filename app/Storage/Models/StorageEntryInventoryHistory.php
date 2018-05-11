<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageEntryInventoryHistory extends Model
{
    protected $table = 'storageEntryInventoryHistory';
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

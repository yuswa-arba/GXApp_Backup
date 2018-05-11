<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageStockAudit extends Model
{
    protected $table = 'storageStockAudit';
    protected $guarded = ['id'];


    public function storageItem()
    {
        return $this->hasOne(StorageItems::class,'itemCode','itemCode');
    }
    
}

<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageItemTypes extends Model
{
    protected $table = 'storageItemTypes';
    protected $guarded = [''];


    public function items()
    {

    }
    
}

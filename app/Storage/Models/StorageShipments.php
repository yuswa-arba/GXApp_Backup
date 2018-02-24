<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageShipments extends Model
{
    protected $table = 'storageShipments';
    protected $guarded = ['id'];


    public function items()
    {

    }
    
}

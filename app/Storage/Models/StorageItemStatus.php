<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\UnitOfMeasurements;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageItemStatus extends Model
{
    protected $table = 'storageItemStatus';
    protected $guarded = ['id'];


}

<?php

namespace App\Storage\Models;

use App\Components\Models\Division;
use App\Components\Models\UnitOfMeasurements;
use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageItemsCategory extends Model
{
    protected $table = 'storageItemCategory';
    protected $guarded = [''];


}

<?php

namespace App\Storage\Models;

use App\Employee\Models\MasterEmployee;
use Illuminate\Database\Eloquent\Model;

class StorageRequestCart extends Model
{
    protected $table = 'storageRequestCart';
    protected $guarded = ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }
}

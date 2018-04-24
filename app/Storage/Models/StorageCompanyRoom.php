<?php

namespace App\Storage\Models;

use App\Components\Models\BranchOffice;
use Illuminate\Database\Eloquent\Model;

class StorageCompanyRoom extends Model
{
    protected $table = 'storageCompanyRoom';
    protected $guarded = ['id'];


    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branchOfficeId');
    }

}

<?php

namespace App\Manager\Models;


use App\Account\Models\User;
use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Traits\GlobalUtils;
use Illuminate\Database\Eloquent\Model;


class EditTimesheet extends Model
{

    protected $table = 'managerEditTimesheet';

    protected $guarded = [''];


    public function division()
    {
        return $this->belongsTo(Division::class, 'divisionId');
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class,'branchOfficeId');
    }

}

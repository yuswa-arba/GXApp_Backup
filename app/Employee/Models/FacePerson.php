<?php

namespace App\Employee\Models;

use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use Illuminate\Database\Eloquent\Model;

class FacePerson extends Model
{

    /*
     * This table is used to integrate with Microsoft FACE API V 1.0
       API Ref:  https://westus.dev.cognitive.microsoft.com/docs/services/563879b61984550e40cbbe8d/operations/563879b61984550f30395246
    */
    protected $table = 'facePersonEmployee';
    protected $guarded= ['id'];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }

}

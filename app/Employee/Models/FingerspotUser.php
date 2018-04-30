<?php

namespace App\Employee\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class FingerspotUser extends Model
{
    use Notifiable;

    protected $table = 'fingerspotUserEmployee';

    protected $guarded = [''];


    public function employee()
    {
        return $this->belongsTo(MasterEmployee::class,'employeeId');
    }


}

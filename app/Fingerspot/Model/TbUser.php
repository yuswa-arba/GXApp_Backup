<?php

namespace App\Fingerspot\Model;

use App\Employee\Models\FingerspotUser;
use Illuminate\Database\Eloquent\Model;

class TbUser extends Model
{

    protected $connection = 'fingerspot';

    protected $table = "tb_user";

    protected $fillable = [
        'pin', 'nama', 'pwd', 'rfid', 'privilege'
    ];

    public $timestamps = false;

}

<?php

namespace App\Fingerspot\Model;

use Illuminate\Database\Eloquent\Model;

class TbDevice extends Model
{
    protected $primaryKey = "No";

    protected $connection = 'fingerspot';

    protected $table = "tb_device";

    protected $fillable = [
        'server_IP', 'server_port', 'device_sn'
    ];

    public $timestamps = false;
}

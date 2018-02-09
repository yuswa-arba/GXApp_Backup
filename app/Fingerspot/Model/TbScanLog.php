<?php

namespace App\Fingerspot\Model;
use Illuminate\Database\Eloquent\Model;

class TbScanLog extends Model
{
    protected $table = "tb_scanlog";

    protected $connection = 'fingerspot';


    protected $fillable = [
        'sn', 'scan_date', 'pin', 'verifymode', 'iomode', 'workcode'
    ];

    public $timestamps = false;
}

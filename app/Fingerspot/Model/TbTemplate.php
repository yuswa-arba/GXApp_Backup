<?php

namespace App\Fingerspot\Model;
use Illuminate\Database\Eloquent\Model;

class TbTemplate extends Model
{

    protected $connection = 'fingerspot';

    protected $table = "tb_template";

    protected $fillable = [
        'pin', 'finger_idx', 'alg_ver', 'template'
    ];

    public $timestamps = false;
}

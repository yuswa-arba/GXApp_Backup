<?php

namespace App\QueueJob\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    protected $table = 'queue_jobs';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}

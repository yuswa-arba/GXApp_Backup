<?php

namespace App\QueueJob\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJobs extends Model
{
    protected $table = 'queue_failed_jobs';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
}

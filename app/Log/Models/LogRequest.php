<?php

namespace App\Log\Models;

use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    protected $table = 'logRequest';
    protected $guarded=['id'];
}
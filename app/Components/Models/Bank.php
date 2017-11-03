<?php

namespace App\Components\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    protected $guarded = ['id'];
}

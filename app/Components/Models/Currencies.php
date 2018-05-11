<?php

namespace App\Components\Models;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    protected $table = 'currencies';
    protected $guarded = ['id'];
}

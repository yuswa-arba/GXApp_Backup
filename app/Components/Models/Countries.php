<?php

namespace App\Components\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table = 'countries';
    protected $guarded = ['id'];
}

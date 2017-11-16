<?php

namespace App\Traits;

use Carbon\Carbon;
use Faker\Provider\Uuid;


/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 2/11/17
 * Time: 10:07 AM
 */


trait GlobalUtils
{
    public function generateUUID()
    {
        return Uuid::uuid();
    }

    public function getFileName($file)
    {
        return str_random(32).'.'.$file->extension();
    }

    public function getImageName($file,$text)
    {
        return str_random(20).str_shuffle($text).'.'.$file->extension();
    }
}

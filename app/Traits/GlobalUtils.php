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
        return str_random(32) . '.' . $file->extension();
    }

    public function getImageName($file, $text)
    {
        return str_random(20) . str_shuffle($text) . '.' . $file->extension();
    }


    public function zeroPrefix($value, $totalZero)
    {
        return str_pad($value, $totalZero, '0', STR_PAD_LEFT);
    }

    public function convertDateDDMMYYYYtoYMD($date)
    {
        $date = str_replace('/', '-', $date);
        return date('ymd', strtotime($date));
    }

    public function generateDateRange($start_date, $end_date, $format)
    {
        $start_date = Carbon::createFromFormat($format, $start_date);
        $end_date = Carbon::createFromFormat($format, $end_date);

        $dates = [];

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format($format);
        }

        return $dates;
    }

    public function currentMonth()
    {
        return Carbon::now()->month;
    }
    public function currentYear()
    {
        return Carbon::now()->year;
    }

    public function randomNumber($length) {
        $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    function randomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

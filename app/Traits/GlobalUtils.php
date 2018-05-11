<?php

namespace App\Traits;

use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
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
        return str_random(20) . str_shuffle(str_replace(' ', '', $text)) . '.' . $file->extension();
    }


    public function zeroPrefix($value, $totalZero)
    {
        return str_pad($value, $totalZero, '0', STR_PAD_LEFT);
    }

    public function zeroPrefixWithSprintf($value, $totalZero)
    {
        $format = "%0" . $totalZero . "d";
        $num_padded = sprintf($format, $value);
        return $num_padded;
    }

    public function convertDateDDMMYYYYtoYMD($date)
    {
        $date = str_replace('/', '-', $date);
        return date('ymd', strtotime($date));
    }

    public function convertDateDDMMYYYYtoYM($date)
    {
        $date = str_replace('/', '-', $date);
        return date('ym', strtotime($date));
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

    public function generateDateRangeFromFormatToFormat($start_date, $end_date, $fromFormat, $toFormat)
    {
        $start_date = Carbon::createFromFormat($fromFormat, $start_date);
        $end_date = Carbon::createFromFormat($fromFormat, $end_date);

        $dates = [];

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format($toFormat);
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

    public function lastYear()
    {
        return Carbon::now()->subYear()->year;
    }

    function diffDay($fromDate, $toDate)
    {
        $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate);
        $toDate = Carbon::createFromFormat('d/m/Y', $toDate);

        return $fromDate->diffInDays($toDate);
    }

    function totalDays($fromDate, $toDate)
    {
        $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate);
        $toDate = Carbon::createFromFormat('d/m/Y', $toDate);

        return $fromDate->diffInDays($toDate->addDay());
    }


    function isDateGreater($fromDate, $toDate)
    {
        $fromDate = Carbon::createFromFormat('d/m/Y', $fromDate);
        $toDate = Carbon::createFromFormat('d/m/Y', $toDate);

        return $toDate->gt($fromDate);
    }


    public function randomNumber($length)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }

    function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


    function clockingVia($id)
    {
        $via = '';
        switch ($id) {
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_KIOSK'] :
                $via = 'Kiosk';
                break;
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_WEB_PORTAL']:
                $via = 'Web Portal';
                break;
            case ConfigCodes::$CLOCK_VIA_TYPE_ID['BY_PERSONAL_DEVICE']:
                $via = 'Personal App';
                break;
            default:
                break;
        }

        return $via;
    }


    /* ex: return $this->getResultWithNullChecker(MasterEmployee::find('d4fb30a0-fc11-3e13-83e9-fa3890e0134e'),'employment','divisionId'); */
    function getResultWithNullChecker1Connection($collection, $a, $result)
    {
        return !is_null($collection->$a) ? $collection->$a->$result : '';
    }

    /* ex: return $this->getResultWithNullChecker(MasterEmployee::find('d4fb30a0-fc11-3e13-83e9-fa3890e0134e'),'employment','division','name'); */
    function getResultWithNullChecker2Connection($collection, $a, $b, $result)
    {
        return !is_null($collection->$a) ? !is_null($collection->$a->$b) ? $collection->$a->$b->$result : '' : '';
    }

    function getResultWithNullChecker3Connection($collection, $a, $b, $c, $result)
    {
        return !is_null($collection->$a) ? !is_null($collection->$a->$b) ? !is_null($collection->$a->$b->$c) ? $collection->$a->$b->$c->$result : '' : '' : '';
    }

    function sortBy($field, &$array, $direction = 'asc')
    {
        usort($array, create_function('$a, $b', '
        $a = $a["' . $field . '"];
        $b = $b["' . $field . '"];

        if ($a == $b) return 0;

        $direction = strtolower(trim($direction));

        return ($a ' . ($direction == 'desc' ? '>' : '<') . ' $b) ? -1 : 1;
    '));

        return true;
    }


}

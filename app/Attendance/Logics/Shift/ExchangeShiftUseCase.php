<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics\Shift;


use Illuminate\Http\Request;

abstract class ExchangeShiftUseCase
{
    public static function attemptExchangeDayOff(Request $request){
        return (new static)->handleAttemptExchangeDayOff($request);
    }

    public static function attemptExchangeWorkingDay(Request $request){
        return (new static)->handleAttemptExchangeWorkingDay($request);
    }

    public static function requestExchangeDayOff(Request $request){
        return (new static)->handleRequestExchange($request);
    }


    public static function answerRequestExchange(Request $request){
        return (new static)->handleAnswerRequest($request);
    }

    abstract public function handleAttemptExchangeDayOff($request);
    abstract public function handleAttemptExchangeWorkingDay($request);
    abstract public function handleRequestExchange($request);
    abstract public function handleAnswerRequest($request);

}
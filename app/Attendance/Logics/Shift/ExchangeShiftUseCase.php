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
    public static function attemptExchange(Request $request){
        return (new static)->handleAttemptExchange($request);
    }

    public static function requestExchange(Request $request){
        return (new static)->handleRequestExchange($request);
    }


    public static function answerRequestExchange(Request $request){
        return (new static)->handleAnswerRequest($request);
    }

    abstract public function handleAttemptExchange($request);
    abstract public function handleRequestExchange($request);
    abstract public function handleAnswerRequest($request);

}
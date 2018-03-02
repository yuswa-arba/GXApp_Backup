<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 13/11/17
 * Time: 8:55 AM
 */

namespace App\Storage\Logics\Requisition;

use Illuminate\Http\Request;

abstract class GetDetailUseCase
{


    public static function getData(Request $request)
    {
        return (new static)->handle($request);
    }

    abstract public function handle($request);

}
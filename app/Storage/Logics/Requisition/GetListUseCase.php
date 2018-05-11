<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 13/11/17
 * Time: 8:55 AM
 */

namespace App\Storage\Logics\Requisition;

use Illuminate\Http\Request;

abstract class GetListUseCase
{


    public static function getData(Request $request)
    {
        return (new static)->handleGetList($request);
    }

    abstract public function handleGetList($request);

}
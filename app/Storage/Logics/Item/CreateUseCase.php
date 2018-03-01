<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 13/11/17
 * Time: 8:55 AM
 */

namespace App\Storage\Logics\Item;


use Illuminate\Http\Request;

abstract class CreateUseCase
{


    public static function create(Request $request)
    {
        return (new static)->handleCreate($request);
    }

    abstract public function handleCreate($request);

}
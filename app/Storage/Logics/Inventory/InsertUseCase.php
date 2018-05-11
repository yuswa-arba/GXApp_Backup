<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 13/11/17
 * Time: 8:55 AM
 */

namespace App\Storage\Logics\Inventory;

use Illuminate\Http\Request;

abstract class InsertUseCase
{


    public static function insert(Request $request)
    {
        return (new static)->handle($request);
    }

    abstract public function handle($request);

}
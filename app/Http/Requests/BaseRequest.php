<?php
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 3/5/18
 * Time: 4:14 PM
 */
class BaseRequest extends Request
{
    public function expectsJson()
    {
        return true;
    }
    public function wantsJson()
    {
        return true;
    }
}
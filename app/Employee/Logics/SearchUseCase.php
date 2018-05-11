<?php
/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 13/11/17
 * Time: 8:55 AM
 */

namespace App\Employee\Logics;




use App\Http\Requests\Employee\EmploymentRequest;
use App\Http\Requests\Employee\MasterEmployeeRequest;
use Illuminate\Http\Request;

abstract class SearchUseCase
{


    public static function search($searchText)
    {
        return (new static)->handleEmployeeSearch($searchText);
    }

    abstract public function handleEmployeeSearch($searchText);



}
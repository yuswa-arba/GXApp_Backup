<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Salary\Logics\Payroll;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class GetReportListUseCase
{

    public static function getData(Request $request)
    {

        $byBranchOffice = false;
        $bySpecificYear = false;

        if($request->byBranchOffice){
            $byBranchOffice = true;
        }

        if($request->bySpecificYear){
            $bySpecificYear = true;
        }


        if($byBranchOffice && !$bySpecificYear){
            return (new static)->handleBySpecificBranchOffice($request);
        }

        if($bySpecificYear && !$byBranchOffice){
            return (new static)->handleBySpecificYear($request);
        }

        if($byBranchOffice && $bySpecificYear){
            return (new static)->handleBySpecificYearAndBranchOffice($request);
        }


        return (new static)->handleDefault($request);
    }

    abstract public function handleDefault($request);
    abstract public function handleBySpecificBranchOffice($request);
    abstract public function handleBySpecificYear($request);
    abstract public function handleBySpecificYearAndBranchOffice($request);
}
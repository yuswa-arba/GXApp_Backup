<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:13 AM
 */

namespace App\Attendance\Logics;


use Illuminate\Http\Request;

abstract class GetSlotDataUseCase
{
    public static function getData(Request $request)
    {

        $byAllStatus = true;
        $byAllRelated = true;

        if ($request->get('relatedBy') != '') {
            $byAllRelated = false;
        }

        if ($request->get('statusBy') != '') {
            $byAllStatus = false;
        }

        // by specific status, by specific job position relation
        if (!$byAllStatus && !$byAllRelated) {
            return (new static)->handleStatusAndRelation($request);
        }

        // by specific status , by all related
        if (!$byAllStatus && $byAllRelated) {
            return (new static)->handleSlotWithSpecificStatus($request);
        }

        // by specific job position relation ,  by all status
        if (!$byAllRelated && $byAllStatus) {
            return (new static)->handleSlotWithSpecificRelation($request);
        }

        return (new static)->handleGetAllSlot($request);

    }

    abstract public function handleGetAllSlot($request);
    abstract public function handleStatusAndRelation($request);
    abstract public function handleSlotWithSpecificStatus($request);
    abstract public function handleSlotWithSpecificRelation($request);

}
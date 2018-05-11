<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Misc;

use App\Attendance\Models\Slots;
use App\Attendance\Transformers\EmployeeAssignListTransformer;
use App\Employee\Models\Employment;
use App\Employee\Models\MasterEmployee;


class GetEmployeeListLogic extends GetDataUseCase
{


    public function handle($request)
    {
        $slot = Slots::find($request->slotId);

        if ($slot->slotMaker->relatedToJobPosition) {
            $employees = $this->getEmployee($slot);
        } else {
            $employees = MasterEmployee::where('hasResigned',0)->get();
        }

        return fractal($employees, new EmployeeAssignListTransformer())->respond(200);


    }

    private function getEmployee($slot)
    {
        $employeeIds = array();

        $employments = Employment::where('jobPositionId', $slot->slotMaker->jobPositionId)->get();

        foreach ($employments as $employment) {
            array_push($employeeIds,$employment->employeeId);
        }

        return MasterEmployee::whereIn('id',$employeeIds)->where('hasResigned',0)->get();

    }
}
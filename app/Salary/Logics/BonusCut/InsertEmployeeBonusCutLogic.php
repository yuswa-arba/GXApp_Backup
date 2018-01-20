<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\BonusCut;

use App\Attendance\Models\Slots;
use App\Salary\Models\EmployeeBonusesCuts;
use App\Salary\Transformers\EmployeeBonusCutTransformer;


class InsertEmployeeBonusCutLogic extends InsertEmployeeBonusCutUseCase
{


    public function handle($request, $employeeId)
    {
        /* Get employee bonus cut model*/
        $employeeBonusCut = EmployeeBonusesCuts::find($request->bonusCutId);

        if ($employeeBonusCut) {
            $update = $employeeBonusCut->update([
                'isUsingFormula' => $request->isUsingFormula,
                'formula' => $request->formula,
                'value' => $request->value,
                'isActive' => $request->isActive
            ]);

            // Insert to database
            if ($update) {
                /* Success */
                $response = array();
                $response['isFailed'] = false;
                $response['message'] = 'Bonus cut has been inserted successfully';
                $response['bonusCut'] = fractal($employeeBonusCut, new EmployeeBonusCutTransformer());

                return response()->json($response, 200);

            } else {
                /* Error */
                $response['isFailed'] = true;
                $response['message'] = 'Unable to insert employee bonus cut';

                return response()->json($response, 200);
            }
        } else {
            /* Error */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find employee bonus cut data';

            return response()->json($response, 200);
        }
    }
}
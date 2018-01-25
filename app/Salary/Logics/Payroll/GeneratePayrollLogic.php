<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Salary\Logics\Payroll;

use App\Salary\Models\GenerateSalaryReportLogs;
use App\Salary\Models\SalaryReport;
use App\Salary\Traits\SalaryCheckerUtil;
use App\Salary\Transformers\PayrollGeneratedSalaryHistoryTransformer;
use App\Salary\Transformers\SalaryReportTransformer;
use App\Traits\GlobalUtils;


class GeneratePayrollLogic extends GenerateUseCase
{

    use SalaryCheckerUtil;

    public function handle($request)
    {


    }

    //1. Get salary report log data
    //2. Get salaryReportIds from salary report log model
    //3. Run check through salary report logs to make sure confirmationStatusId is correct
    //4. Get Salary Report Log data
    //5. Generate preview of whats going to be generated :
    // - valid stage salary report lists (all salary report logs model that confirmation status ID == 1)
    // - stage 1 salary report list (all salary report logs model that confirmation status ID == 4)
    // - stage 2 salary report list (all salary report logs model that confirmation status ID == 5)
    public function handleAttempt($request)
    {
        /* Response array */
        $response = array();

        /* Generate Salary Repot Log*/
        $generateSalaryReport = GenerateSalaryReportLogs::find($request->generateSalaryReportLogId);

        /* Salary Reports Data */
        $salaryReports = SalaryReport::whereIn('id', explode(' ', $generateSalaryReport->salaryReportIds))->get();

        if ($generateSalaryReport) {

            /* Check */
           $this->checkStage2Confirm($generateSalaryReport,$salaryReports);

            /* Insert to details*/
            $details = array();
            $details['confirmed'] = [];
            $details['unconfirmed'] =[];
            $details['stage1Confirmed'] = [];
            $details['stage2Confirmed'] = [];
            $details['waiting']=[];

            foreach ($salaryReports as $salaryReport){
                switch ($salaryReport->confirmationStatusId){
                    case 1 :
                        array_push($details['confirmed'],fractal($salaryReport,new SalaryReportTransformer())->toArray()['data']);
                        break;
                    case 2 :
                        array_push($details['unconfirmed'],fractal($salaryReport,new SalaryReportTransformer())->toArray()['data']);
                        break;
                    case 3 :
                        array_push($details['waiting'],fractal($salaryReport,new SalaryReportTransformer())->toArray()['data']);
                        break;
                    case 4 :
                        array_push($details['stage1Confirmed'],fractal($salaryReport,new SalaryReportTransformer())->toArray()['data']);
                        break;
                    case 5 :
                        array_push($details['stage2Confirmed'],fractal($salaryReport,new SalaryReportTransformer())->toArray()['data']);
                        break;
                    default:break;
                }
            }

            /* Insert to response array */
            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['summary'] = fractal($generateSalaryReport,new PayrollGeneratedSalaryHistoryTransformer())->toArray()['data'];
            $response['details'] = $details;

            return response()->json($response,200);

        } else { // Error response

            $response['isFailed'] = true;
            $response['message'] = 'Unable to find generate salary report';
            return response()->json($response, 200);

        }

    }


}
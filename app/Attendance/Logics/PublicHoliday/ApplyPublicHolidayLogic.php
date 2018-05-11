<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 23/12/17
 * Time: 3:15 PM
 */

namespace App\Attendance\Logics\PublicHoliday;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\EmployeeSlotSchedule;
use App\Attendance\Models\KioskActivity;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\PublicHoliday;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Components\Models\Religion;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ResponseCodes;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class ApplyPublicHolidayLogic extends ApplyPubHolidayUseCase
{
    use GlobalUtils;

    private $client;

    public function __construct()
    {

    }


    /*|---------------------
      | RELATED TO RELIGION
      |---------------------
      | 1. Get Employee with this specific religion
      | 2. Sort employee in array based on their slot ID position order
      | 3. Loop through slots and Add day off based on the order
    */
    public function handle($request)
    {

        $response = array();

        $publicHoliday = PublicHoliday::find($request->id);

        if ($publicHoliday) {

            # enable this to prevent applied public holiday to executed again
            //if ($publicHoliday->isApplied) { //error response
            //    $response['isFailed'] = true;
            //    $response['message'] = 'Public holiday has been applied before';
            //    return response()->json($response, 200);
            //}


            if ($publicHoliday->isGeneral) {

                $this->addDayOffGeneralPublicHoliday($publicHoliday)->updatePublicHolidayIsApplied($publicHoliday);

                // success response
                $response['isFailed'] = false;
                $response['message'] = 'Public holiday has been applied successfully';

                return response()->json($response,200);


            } else {

                $religion = Religion::find($publicHoliday->religionId);

                if ($religion) {

                    $this->addDayOffSpecificReligion($publicHoliday)->updatePublicHolidayIsApplied($publicHoliday);

                    // success response
                    $response['isFailed'] = false;
                    $response['message'] = 'Public holiday has been applied successfully';

                    return response()->json($response,200);

                } else { // error response undefined religion
                    $response['isFailed'] = true;
                    $response['message'] = 'Religion is undefined';
                    return response()->json($response, 200);
                }
            }

        } else { // error response
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find public holiday schedule data';
            return response()->json($response, 200);
        }

    }

    private function addDayOffGeneralPublicHoliday($publicHoliday)
    {
        $employeeIds = MasterEmployee::where('hasResigned',0)->get()->pluck('id');

        $filteredData = array();

        foreach ($employeeIds as $key => $employeeId) { // get slot Ids

            $data = ['slotMakerId' => 1, 'slotId' => 1, 'positionOrder' => 1,'employeeId'=>$employeeId];

            $assignedToSlot = EmployeeSlotSchedule::where('employeeId', $employeeId)->first();

            if ($assignedToSlot) {

                if ($this->getResultWithNullChecker1Connection($assignedToSlot, 'slot', 'slotMakerId') != "") {

                    $slotMakerId = $this->getResultWithNullChecker1Connection($assignedToSlot, 'slot', 'slotMakerId');
                    $positionOrder = $this->getResultWithNullChecker1Connection($assignedToSlot, 'slot', 'positionOrder');

                    $data = ['slotMakerId' => $slotMakerId, 'slotId' => $assignedToSlot->slotId, 'positionOrder' => $positionOrder,'employeeId'=>$employeeId];
                }
            }

            if (!in_array($data, $filteredData)) {
                array_push($filteredData, $data);
            }
        }


        if (count($filteredData) > 0) {

            # get a list of sort columns and their data to pass to array_multisort
            $sortFilteredSlots = array();
            foreach ($filteredData as $key => $filtered) {
                $sortFilteredSlots['slotMakerId'][$key] = $filtered['slotMakerId'];
                $sortFilteredSlots['positionOrder'][$key] = $filtered['positionOrder'];
            }

            # sort filtered slots array
            array_multisort($sortFilteredSlots['slotMakerId'], SORT_ASC, $sortFilteredSlots['positionOrder'], SORT_ASC, $filteredData);
        }

        $lastFilteredSlotMakerId = 0;
        $day = 0;
        foreach ($filteredData as $filtered) {

            if ($filtered['slotMakerId'] != $lastFilteredSlotMakerId) {
                $lastFilteredSlotMakerId = $filtered['slotMakerId'];
                $day = 0; // new increment start at 0
            } else {
                $day++; // increment day
            }


            # setting date based on the position order
            $parseDayOffDate = Carbon::createFromFormat('d/m/Y', $publicHoliday->date);

            $applyDate = $parseDayOffDate->format('d/m/Y');

            if ($day != 0) {
                if($filtered['slotId']!=1){ #if its not general slot , add days
                    $applyDate = $parseDayOffDate->addDays($day)->format('d/m/Y');
                }
            }

            # insert day off
            PublicHolidaySchedule::updateOrCreate(
                [
                    'employeeId' => $filtered['employeeId'],
                    'pubHolidayId' => $publicHoliday->id
                ],
                [
                    'originalDate' => $publicHoliday->date,
                    'applyDate'=>$applyDate,
                    'positionOrder'=>$filtered['positionOrder'],
                    'fromSlotId'=>$filtered['slotId']
                ]
            );
        }

        return $this;
    }

    private function addDayOffSpecificReligion($publicHoliday)
    {

        $employeeIds = MasterEmployee::where('religionId', $publicHoliday->religionId)
            ->where('hasResigned',0)->get()->pluck('id');

        $filteredData = array();

        foreach ($employeeIds as $key => $employeeId) { // get slot Ids

            $data = ['slotMakerId' => 1, 'slotId' => 1, 'positionOrder' => 1,'employeeId'=>$employeeId];

            $assignedToSlot = EmployeeSlotSchedule::where('employeeId', $employeeId)->first();

            if ($assignedToSlot) {

                if ($this->getResultWithNullChecker1Connection($assignedToSlot, 'slot', 'slotMakerId') != "") {

                    $slotMakerId = $this->getResultWithNullChecker1Connection($assignedToSlot, 'slot', 'slotMakerId');
                    $positionOrder = $this->getResultWithNullChecker1Connection($assignedToSlot, 'slot', 'positionOrder');

                    $data = ['slotMakerId' => $slotMakerId, 'slotId' => $assignedToSlot->slotId, 'positionOrder' => $positionOrder,'employeeId'=>$employeeId];
                }
            }

            if (!in_array($data, $filteredData)) {
                array_push($filteredData, $data);
            }
        }


        if (count($filteredData) > 0) {

            # get a list of sort columns and their data to pass to array_multisort
            $sortFilteredSlots = array();
            foreach ($filteredData as $key => $filtered) {
                $sortFilteredSlots['slotMakerId'][$key] = $filtered['slotMakerId'];
                $sortFilteredSlots['positionOrder'][$key] = $filtered['positionOrder'];
            }

            # sort filtered slots array
            array_multisort($sortFilteredSlots['slotMakerId'], SORT_ASC, $sortFilteredSlots['positionOrder'], SORT_ASC, $filteredData);
        }

        $lastFilteredSlotMakerId = 0;
        $day = 0;
        foreach ($filteredData as $filtered) {

            if ($filtered['slotMakerId'] != $lastFilteredSlotMakerId) {
                $lastFilteredSlotMakerId = $filtered['slotMakerId'];
                $day = 0; // new increment start at 0
            } else {
                $day++; // increment day
            }


            # setting date based on the position order
            $parseDayOffDate = Carbon::createFromFormat('d/m/Y', $publicHoliday->date);

            $applyDate = $parseDayOffDate->format('d/m/Y');

            if ($day != 0) {
                $applyDate = $parseDayOffDate->addDays($day)->format('d/m/Y');
            }

            # insert day off
            PublicHolidaySchedule::updateOrCreate(
                [
                    'employeeId' => $filtered['employeeId'],
                    'pubHolidayId' => $publicHoliday->id
                ],
                [
                    'originalDate' => $publicHoliday->date,
                    'applyDate'=>$applyDate,
                    'positionOrder'=>$filtered['positionOrder'],
                    'fromSlotId'=>$filtered['slotId']
                ]
            );
        }

       return $this;

    }

    private function updatePublicHolidayIsApplied($publicHoliday){
        $publicHoliday->isApplied=1;
        $publicHoliday->save();
        return $this;
    }
}

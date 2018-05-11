<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Attendance;

use App\Attendance\Logics\PublicHoliday\ApplyPubHolidayUseCase;
use App\Attendance\Logics\PublicHoliday\ApplyPublicHolidayLogic;
use App\Attendance\Models\PublicHoliday;
use App\Attendance\Models\PublicHolidaySchedule;
use App\Attendance\Transformers\PublicHolidayTransformer;
use App\Http\Controllers\Controller;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicHolidayController extends Controller
{

    use GlobalUtils;

    public function __construct()
    {
//        $this->middleware(['permission:view attendance']);
    }

    public function create(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(),
            [
                'dateStart' => 'required',
                'dateEnd' => 'required',
                'holidayName' => 'required',
                'onYear' => 'required',
                'religionId' => 'required'
            ]
        );


        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }


        //is valid

        $isGeneral = 0;
        $religionId = $request->religionId;
        $insertedIds = array();

        if ($request->religionId == 'all') {
            $isGeneral = 1;
            $religionId = '';
        }

        if ($request->dateStart != $request->dateEnd) { // if date start and date end is not the same

            $dateRange = $this->generateDateRange($request->dateStart, $request->dateEnd, 'd/m/Y');

            if (count($dateRange) > 0) {
                foreach ($dateRange as $date) {

                    $insert = PublicHoliday::updateOrCreate(
                        [
                            'date' => $date,
                            'name' => $request->holidayName,
                        ],
                        [
                            'isGeneral' => $isGeneral,
                            'religionId' => $religionId,
                            'onYear' => $request->onYear
                        ]
                    );

                    if ($insert) {
                        array_push($insertedIds, $insert->id);
                    }

                }
            } else {

                $response['isFailed'] = true;
                $response['message'] = 'Invalid date range';
                return response()->json($response, 200);

            }

        } else { // else if the same

            $insert = PublicHoliday::updateOrCreate(
                [
                    'date' => $request->dateStart,
                    'name' => $request->holidayName,
                ],
                [
                    'isGeneral' => $isGeneral,
                    'religionId' => $religionId,
                    'onYear' => $request->onYear
                ]
            );

            if ($insert) {
                array_push($insertedIds, $insert->id);
            }

        }

        //return success response
        $response['isFailed'] = false;
        $response['message'] = 'Public holiday has been inserted successfully';
        $response['publicHolidays'] = fractal(PublicHoliday::whereIn('id', $insertedIds)->get(), new PublicHolidayTransformer());

        return response()->json($response, 200);
    }

    public function getList()
    {
        $response = array();
        $publicHolidaySchedules = PublicHoliday::orderBy('created_at', 'desc')->get();

        if ($publicHolidaySchedules) {

            $response['isFailed'] = false;
            $response['message'] = 'Success';
            $response['publicHolidays'] = fractal($publicHolidaySchedules, new PublicHolidayTransformer());

            return response()->json($response, 200);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Public holiday scheudle data is empty';
            return response()->json($response, 200);
        }
    }

    public function delete(Request $request)
    {
        $response = array();

        $validator = Validator::make($request->all(), ['id' => 'required']);


        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }


        //is valid

        $pubHoliday = PublicHoliday::find($request->id);

        if ($pubHoliday) {

            if ($pubHoliday->isApplied) {
                # delete all public holiday in schedule
                PublicHolidaySchedule::where('pubHolidayId',$pubHoliday->id)->delete();
            }

            if ($pubHoliday->delete()) {

                $response['isFailed'] = false;
                $response['message'] = 'Has been deleted successfully';
                return response()->json($response, 200);

            } else {
                $response['isFailed'] = true;
                $response['message'] = 'Unable to delete';
                return response()->json($response, 200);
            }


        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find public holiday schedule data';
            return response()->json($response, 200);
        }

    }

    public function apply(Request $request)
    {
        $response = array();
        $validator = Validator::make($request->all(), ['id' => 'required']);


        if ($validator->fails()) {
            $response['isFailed'] = true;
            $response['message'] = 'Missing required parameters';
            return response()->json($response, 200);
        }

        //is valid

        $pubHolidaySchedule = PublicHoliday::find($request->id);

        if ($pubHolidaySchedule) {

            return ApplyPublicHolidayLogic::apply($request);

        } else {
            $response['isFailed'] = true;
            $response['message'] = 'Unable to find public holiday schedule data';
            return response()->json($response, 200);
        }
    }

}

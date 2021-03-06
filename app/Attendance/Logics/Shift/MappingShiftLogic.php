<?php

/**
 * Created by PhpStorm.
 * User: kevinpurwono
 * Date: 5/12/17
 * Time: 11:12 AM
 */

namespace App\Attendance\Logics\Shift;

use App\Attendance\Models\SlotShiftSchedule;
use App\Traits\GlobalUtils;

class MappingShiftLogic extends MappingUseCase
{
    use GlobalUtils;

    /**
     * @param $request
     */
    public function handleMapping($request)
    {
        $dates = $this->getDates($request->dateStart, $request->dateEnd);

        if (count($dates) > 0) {

            // insert if shift is not default, otherwise remove it

            if($request->shiftId!=1){
                foreach ($dates as $date) {
                    SlotShiftSchedule::updateOrCreate(
                        ['slotId' => $request->slotId, 'date' => $date],
                        ['shiftId' => $request->shiftId]);
                }
            } else {
                foreach ($dates as $date) {
                    SlotShiftSchedule::where('slotId',$request->slotId)->where('date',$date)->delete();
                }
            }

            /* Return success response */
            $response['isFailed'] = false;
            $response['message'] = 'Shift has been mapped successfully';

        } else {
            /* Return error response */
            $response['isFailed'] = true;
            $response['message'] = 'Unable to map shift to slot, undefined dates';

        }

        return response()->json($response, 200);
    }

    private function getDates($dateStart, $dateEnd)
    {
        $dates = [$dateStart];

        if ($dateStart != $dateEnd) {
            $dates = $this->generateDateRange($dateStart, $dateEnd, 'd/m/Y');
        }
        // return date start
        return $dates;
    }
}
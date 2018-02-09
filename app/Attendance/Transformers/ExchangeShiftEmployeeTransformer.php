<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\ExchangeShiftEmployee;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Models\SlotShiftSchedule;
use App\Employee\Models\MasterEmployee;
use App\Http\Controllers\BackendV1\API\Traits\ConfigCodes;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ExchangeShiftEmployeeTransformer extends TransformerAbstract
{

    use GlobalUtils;

    public function transform(ExchangeShiftEmployee $exchangeShiftEmployee)
    {
        return [
            'id' => $exchangeShiftEmployee->id,
            'requesterEmployeeName' => $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'requesterEmployee', 'givenName'),
            'fromShiftDetail' => $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'fromShift', 'name') .
                " ("
                . $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'fromShift', 'workStartAt')
                . "-"
                . $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'fromShift', 'workEndAt')
                . ")",
            'fromDate' => $exchangeShiftEmployee->fromDate,
            'ownerEmployeeName' => $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'ownerEmployee', 'givenName'),
            'toShiftDetail' => $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'toShift', 'name') .
                " ("
                . $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'toShift', 'workStartAt')
                . "-"
                . $this->getResultWithNullChecker1Connection($exchangeShiftEmployee, 'toShift', 'workEndAt')
                . ")",
            'toDate' => $exchangeShiftEmployee->toDate,
            'confirmType' => $exchangeShiftEmployee->confirmType,
            'confirmTypeName' => $this->getConfirmTypeName($exchangeShiftEmployee->confirmType),
            'confirmedAt' => $exchangeShiftEmployee->confirmedDate . " " . $exchangeShiftEmployee->confirmedTime,
            'isDayOff' =>$exchangeShiftEmployee->isDayOff
        ];
    }

    private function getConfirmTypeName($confirmType)
    {
        switch ($confirmType) {
            case ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['WAITING']:
                return "Waiting";
                break;
            case ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['CONFIRM']:
                return "Confirmed";
                break;
            case ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['DECLINE']:
                return "Declined";
                break;
            case ConfigCodes::$EXCHANGE_SHIFT_CONFIRM_TYPE['INVALID']:
                return "Invalid";
                break;
            default:
                return "Undefined";
                break;
        }
    }

}

<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\KioskActivity;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class KioskTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'kioskActivity'
    ];

    public function transform(Kiosks $kiosk)
    {
        return [
            'id' => $kiosk->id,
            'codeName' => $kiosk->codeName,
            'description' => $kiosk->description,
            'activationCode' => $kiosk->activationCode,
            'passcode' => $kiosk->passcode,
            'apiToken' => $kiosk->apiToken,
            'batteryPower' => $kiosk->batteryPower,
            'isCharging' => $kiosk->isCharging,
            'isActivated' => $kiosk->isActivated,
            'isInMaintenanceMode' => $kiosk->isInMaintenanceMode
        ];
    }


    public function includeKioskActivity(Kiosks $kiosk)
    {
        $kioskActivity = KioskActivity::where('kioskId', $kiosk->id)->get();
        return $this->collection($kioskActivity, new KioskActivityTransformer(), 'kioskActivity');
    }

}

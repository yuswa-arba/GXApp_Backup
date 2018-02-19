<?php

namespace App\Attendance\Transformers;

use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class KioskListTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Kiosks $kiosks)
    {
        return [
            'id' => $kiosks->id,
            'codeName' => $kiosks->codeName,
            'description' => $kiosks->description,
            'activationCode' => $kiosks->activationCode,
            'passcode' => $kiosks->passcode,
//            'apiToken' => $kiosks->apiToken,
            'batteryPower' => $kiosks->batteryPower,
            'isCharging' => $kiosks->isCharging,
            'isActivated' => $kiosks->isActivated,
            'isInMaintenanceMode' => $kiosks->isInMaintenanceMode,
            'lastHeartBeat'=>$kiosks->lastHeartBeat,
            'totalSynced'=>$kiosks->totalSynced,
            'totalUnsynced'=>$kiosks->totalUnsynced,
            'editing' => false
        ];
    }
}

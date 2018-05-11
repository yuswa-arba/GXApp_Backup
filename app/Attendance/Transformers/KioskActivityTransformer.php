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

class KioskActivityTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(KioskActivity $kioskActivity)
    {
        return [
            'id' => $kioskActivity->id,
            'kioskId' =>$kioskActivity->kioskId,
            'socketId' =>$kioskActivity->socketId,
            'isLogined' =>$kioskActivity->isLogined,
            'lastLoginAt' =>$kioskActivity->lastLoginAt,
            'isConnectedToNetwork' =>$kioskActivity->isConnectedToNetwork,
            'lastConnectionAt' =>$kioskActivity->lastConnectionAt,
            'lastAPITokenRefreshAt' =>$kioskActivity->lastAPITokenRefreshAt,
            'lastRequestURL' =>$kioskActivity->lastRequestURL,
            'lastRequestAt' =>$kioskActivity->lastRequestAt,
            'lastRequestBy' =>$kioskActivity->lastRequestBy
        ];
    }
}

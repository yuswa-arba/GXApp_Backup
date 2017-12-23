<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Component;

use App\Attendance\Models\Kiosks;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\KioskListTransformer;
use App\Attendance\Transformers\ShiftListTransformer;
use App\Attendance\Transformers\SlotListTransformer;
use App\Attendance\Transformers\SlotMakerListTransformer;
use App\Components\Models\JobPosition;
use App\Components\Transformers\JobPositionListTransfomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetListController extends Controller
{

    public function jobPosition($id)
    {
        return fractal(JobPosition::find($id),new JobPositionListTransfomer())->respond(200);
    }


    public function jobPositions()
    {
        return fractal(JobPosition::all(),new JobPositionListTransfomer())->respond(200);
    }

    public function slotMaker($id)
    {
        return fractal(SlotMaker::find($id),new SlotMakerListTransformer())->respond(200);
    }

    public function slotMakers()
    {
        return fractal(SlotMaker::all(), new SlotMakerListTransformer())->respond(200);
    }

    public function slot($id)
    {
        return fractal(Slots::find($id),new SlotListTransformer())->respond(200);
    }

    public function slots()
    {
        return fractal(Slots::all(), new SlotListTransformer())->respond(200);
    }

    public function shift($id)
    {
        return fractal(Shifts::find($id),new ShiftListTransformer())->respond(200);
    }

    public function shifts()
    {
        return fractal(Shifts::all(), new ShiftListTransformer())->respond(200);
    }

    public function kiosk($id)
    {
        return fractal(Kiosks::where('id',$id)->where('isDeleted',0)->first(),new KioskListTransformer())->respond(200);
    }

    public function kiosks()
    {
        return fractal(Kiosks::where('isDeleted',0)->get(), new KioskListTransformer())->respond(200);
    }
}

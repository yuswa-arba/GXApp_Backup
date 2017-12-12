<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Component;

use App\Attendance\Models\Shifts;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\ShiftListTransformer;
use App\Attendance\Transformers\SlotListTransformer;
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
}

<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Component;

use App\Attendance\Models\AttendanceApproval;
use App\Attendance\Models\Kiosks;
use App\Attendance\Models\LeaveApproval;
use App\Attendance\Models\LeaveType;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\SlotMaker;
use App\Attendance\Models\Slots;
use App\Attendance\Transformers\KioskListTransformer;
use App\Attendance\Transformers\ShiftListTransformer;
use App\Attendance\Transformers\SlotListTransformer;
use App\Attendance\Transformers\SlotMakerListTransformer;
use App\Components\Models\BranchOffice;
use App\Components\Models\Division;
use App\Components\Models\JobPosition;
use App\Components\Transformers\BasicComponentTrasnformer;
use App\Components\Transformers\DivisionListTransfomer;

use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetListController extends Controller
{
    use GlobalUtils;

    public function jobPosition($id)
    {
        return fractal(JobPosition::find($id), new BasicComponentTrasnformer())->respond(200);
    }


    public function jobPositions()
    {
        return fractal(JobPosition::all(), new BasicComponentTrasnformer())->respond(200);
    }

    public function slotMaker($id)
    {
        return fractal(SlotMaker::find($id), new SlotMakerListTransformer())->respond(200);
    }

    public function slotMakers()
    {
        return fractal(SlotMaker::whereYear('created_at', $this->currentYear())->get(), new SlotMakerListTransformer())->respond(200);
    }

    public function slot($id)
    {
        return fractal(Slots::find($id), new SlotListTransformer())->respond(200);
    }

    public function slots()
    {
        return fractal(Slots::whereYear('created_at', $this->currentYear())->orWhere('id',1)->get(), new SlotListTransformer())->respond(200);
    }

    public function shift($id)
    {
        return fractal(Shifts::find($id), new ShiftListTransformer())->respond(200);
    }

    public function shifts()
    {
        return fractal(Shifts::all(), new ShiftListTransformer())->respond(200);
    }

    public function kiosk($id)
    {
        return fractal(Kiosks::where('id', $id)->where('isDeleted', 0)->first(), new KioskListTransformer())->respond(200);
    }

    public function kiosks()
    {
        return fractal(Kiosks::where('isDeleted', 0)->get(), new KioskListTransformer())->respond(200);
    }


    public function division($id)
    {
        return fractal(Division::where('id', $id)->first(), new BasicComponentTrasnformer())->respond(200);
    }


    public function divisions()
    {
        return fractal(Division::all(), new BasicComponentTrasnformer())->respond(200);
    }

    public function branchOffice($id)
    {
        return fractal(BranchOffice::where('id', $id)->first(), new BasicComponentTrasnformer())->respond(200);
    }


    public function branchOffices()
    {
        return fractal(BranchOffice::all(), new BasicComponentTrasnformer())->respond(200);
    }

    public function attdApproval($id)
    {
        return fractal(AttendanceApproval::where('id', $id)->first(), new BasicComponentTrasnformer())->respond(200);
    }

    public function attdApprovals()
    {
        return fractal(AttendanceApproval::all(), new BasicComponentTrasnformer())->respond(200);
    }

    public function leaveApproval($id)
    {
        return fractal(LeaveApproval::where('id', $id)->first(), new BasicComponentTrasnformer())->respond(200);
    }

    public function leaveApprovals()
    {
        return fractal(LeaveApproval::all(), new BasicComponentTrasnformer())->respond(200);

    }

    public function leaveType($id)
    {
        return fractal(LeaveType::where('id',$id),new BasicComponentTrasnformer())->respond(200);
    }

    public function leaveTypes()
    {
        return fractal(LeaveType::all(),new BasicComponentTrasnformer())->respond(200);
    }

}

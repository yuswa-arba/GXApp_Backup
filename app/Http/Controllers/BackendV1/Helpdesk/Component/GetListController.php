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
use App\Components\Models\Religion;
use App\Components\Models\UnitOfMeasurementType;
use App\Components\Transformers\BasicComponentTrasnformer;
use App\Components\Transformers\BasicSettingTrasnformer;
use App\Components\Transformers\DivisionListTransfomer;

use App\Notification\Models\NotificationGroupType;
use App\Salary\Models\PayrollSetting;
use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetListController extends Controller
{
    use GlobalUtils;


    public function months()
    {
        $months = array();

        $months[0]['number']='01';
        $months[0]['name'] = 'January';

        $months[1]['number']='02';
        $months[1]['name'] = 'February';

        $months[2]['number']='03';
        $months[2]['name'] = 'March';

        $months[3]['number']='04';
        $months[3]['name'] = 'April';

        $months[4]['number']='05';
        $months[4]['name'] = 'May';

        $months[5]['number']='06';
        $months[5]['name'] = 'June';

        $months[6]['number']='07';
        $months[6]['name'] = 'July';

        $months[7]['number']='08';
        $months[7]['name'] = 'August';

        $months[8]['number']='09';
        $months[8]['name'] = 'September';

        $months[9]['number']='10';
        $months[9]['name'] = 'October';

        $months[10]['number']='11';
        $months[10]['name'] = 'November';

        $months[11]['number']='12';
        $months[11]['name'] = 'December';

        return response()->json($months,200);

    }

    public function religion($id)
    {
        return fractal(Religion::find($id), new BasicComponentTrasnformer())->respond(200);
    }
    public function religions()
    {
        return fractal(Religion::all(), new BasicComponentTrasnformer())->respond(200);
    }
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
        return fractal(LeaveType::where('id',$id)->first(),new BasicComponentTrasnformer())->respond(200);
    }

    public function leaveTypes()
    {
        return fractal(LeaveType::all(),new BasicComponentTrasnformer())->respond(200);
    }

    public function notificationGroupType($id)
    {
        return fractal(NotificationGroupType::where('id',$id)->first(),new BasicComponentTrasnformer())->respond(200);
    }

    public function notificationGroupTypes()
    {
        return fractal(NotificationGroupType::all(),new BasicComponentTrasnformer())->respond(200);
    }

    public function unitOfMeasurementTypes()
    {
        return fractal(UnitOfMeasurementType::all(),new BasicComponentTrasnformer())->respond(200);

    }

}

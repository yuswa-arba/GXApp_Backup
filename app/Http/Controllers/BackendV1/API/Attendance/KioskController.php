<?php

namespace App\Http\Controllers\BackendV1\API\Attendance;

use App\Account\Models\User;
use App\Account\Traits\TokenUtils;
use App\Attendance\Logics\AttendanceLogic;
use App\Attendance\Logics\Kiosk\AuthenticationLogic;
use App\Attendance\Logics\Kiosk\KioskAuthLogic;
use App\Attendance\Models\KioskActivity;
use App\Attendance\Models\Kiosks;
use App\Attendance\Transformers\KioskTransformer;
use App\Http\Controllers\BackendV1\API\Traits\IssueTokenTrait;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;


class KioskController extends Controller
{

    public function detail($id)
    {


        return fractal(Kiosks::find($id),new KioskTransformer())->includeKioskActivity()->respond(200);
    }
}

<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\SuperAdmin;


use App\Components\Transformers\BasicComponentTrasnformer;
use App\Employee\Transformers\EmployeeBriefDetailTransfomer;
use App\Employee\Transformers\EmployeeListTransfomer;
use App\Http\Controllers\Controller;
use App\Notification\Models\NotificationGroupType;
use App\Notification\Models\NotificationRecipientGroup;
use App\Notification\Models\Notifications;
use App\Notification\Transformers\NotificationListTransformer;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    use GlobalUtils;

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required'
            ]);

        if($validator->fails()){
            $request->session()->flash('alert-danger', 'Username and Password cannot be empty');
            return redirect()->back();
        }

        if($request->username != env('SUPERADMIN_USER','superadmin')){
            $request->session()->flash('alert-danger', 'Username is invalid');
            return redirect()->back();
        }

        if($request->password != env('SUPERADMIN_PASSWORD','password')){
            $request->session()->flash('alert-danger', 'Password is incorrect');
            return redirect()->back();
        }

        //log in for 30 minutes
        Cookie::queue('superadmin-logined',Hash::make($request->username), 30); // 30 minutes

        return redirect('/superadmin');

    }

    public function logout()
    {
        //clear cookies
        Cookie::queue(Cookie::forget('superadmin-logined'));
        return redirect()->route('superadmin.login');
    }

}

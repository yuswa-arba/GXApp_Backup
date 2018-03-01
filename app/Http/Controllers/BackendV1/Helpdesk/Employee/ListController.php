<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Employee;

use App\Employee\Logics\EmployeeSearchLogic;
use App\Employee\Models\MasterEmployee;
use App\Employee\Transformers\EmployeeListTransfomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListController extends Controller
{


//    public function __construct()
//    {
//        $this->middleware(['role:admin','permission:view employee']);
//    }

    public function mainList()
    {
        $employees = MasterEmployee::where('hasResigned','!=',1)->orderBy('givenName','asc')->paginate(100);
        return fractal($employees,new EmployeeListTransfomer())->respond(200);
    }

    public function resignedList()
    {
        $employees = MasterEmployee::where('hasResigned','=',1)->get()->sortBy('givenName');
        return fractal($employees,new EmployeeListTransfomer())->respond(200);
    }

    public function searchEmployee($searchText)
    {
        return EmployeeSearchLogic::search($searchText);
    }
}

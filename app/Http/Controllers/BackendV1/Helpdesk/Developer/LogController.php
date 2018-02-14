<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Developer;


use App\Http\Controllers\Controller;
use App\Log\Models\LogRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;


class LogController extends Controller
{
    public function __construct()
    {

    }


    public function getList(Request $request)
    {
        $this->validate($request,['whereDate'=>'required']);
        //is valid

        // Star Convert date
        $whereDate =  Carbon::createFromFormat('d/m/Y',$request->whereDate);
        $starttoday = $whereDate->format('Y-m-d 00:00:01'); //sql format
        $endtoday   = $whereDate->format('Y-m-d 23:59:59'); //sql format
        // End Convert date

        $dataWhere = LogRequest::where('created_at', '>=', $starttoday)->where('created_at', '<=', $endtoday)->orderBy('id','DESC');
        $convertJson = [];
        $no = $dataWhere->count();
        foreach ($dataWhere->get() as $uv){
            $dataJson =
                '<tr class="filter-log">
                    <td>'.$uv->id.'</td>
                    <td>'.$uv->causer.'</td>
                    <td>'.$uv->via.'</td>
                    <td>'.$uv->causerIPAddress.'</td>
                    <td>'.$uv->subject.'</td>
                    <td>'.$uv->action.'</td>
                    <td>'.$uv->level.'</td>
                    <td>'.$uv->description.'</td>
                    <td>'.$uv->created_at.'</td>
                 </tr>'
            ;
            $no -=1;
            array_push($convertJson,$dataJson);
        }

        return response()->json($convertJson);
    }

}

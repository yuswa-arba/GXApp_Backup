<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Developer;

use App\Http\Controllers\Controller;
use App\QueueJob\Models\FailedJobs;
use App\QueueJob\Models\Jobs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class QueueJobController extends Controller
{
    public function __construct()
    {


    }

    public function getDataJobs()
    {
        //$data = Jobs::all();
        $data = Jobs::orderBy('id', 'desc')->get();
        return response()->json($data);
    }

    public function getDataFailedJobs()
    {
        $data = FailedJobs::orderBy('id', 'desc')->get();
        return response()->json($data);
    }

    public function retryJob(Request $request)
    {
        $id = $request->id;
        $times = Carbon::now()->addSeconds(10);
        $queue = $_GET['queue'];
        if ($id) {
            Artisan::call('queue:listen', ['id' => $id, '--queue' => $queue]);
        } else {
            Artisan::call('queue:listen', ['--queue' => $queue]);
        }
    }

    public function deleteJobs(Request $request)
    {
        $id = $request->get('id');
        if ($id) {
            Jobs::find($id)->delete();
            return response()->json('True ID Delete');
        } else {
            Jobs::truncate();
            return response()->json('True All');
        }
    }

    public function retryFailedJob(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $queue = $request->queue;
            Artisan::call("queue:retry", ['id' => [$id], Carbon::now()->addSeconds(10)]);
            echo 'Retry ID : ' . $id;
        } else {
            Artisan::call("queue:retry", ['id' => ['all'], Carbon::now()->addSeconds(10)]);
            echo 'Retry All';
        }
    }

    public function deleteFailedJobs(Request $request)
    {
        $id = $request->id;
        if ($id) {
            Artisan::call("queue:forget", ['id' => [$id]]);
        } else {
            Artisan::call("queue:flush");
        }
    }


}

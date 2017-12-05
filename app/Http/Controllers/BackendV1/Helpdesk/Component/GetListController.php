<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Component;

use App\Components\Models\JobPosition;
use App\Components\Transformers\JobPositionListTransfomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GetListController extends Controller
{
    public function jobPosition()
    {
        return fractal(JobPosition::all(),new JobPositionListTransfomer())->respond(200);
    }
}

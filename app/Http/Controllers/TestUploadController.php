<?php

namespace App\Http\Controllers;

use App\Traits\GlobalUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestUploadController extends Controller
{
    use GlobalUtils;
    public function upload(Request $request)
    {
        $request->validate(['name' => 'required', 'employeePhoto' => 'required']);

        /*Handle image uploads*/
        if($request->hasFile('employeePhoto') && $request->file('employeePhoto')->isValid()){
            $filename = $this->getFileName($request->employeePhoto);
            $request->employeePhoto->move(base_path('public/images'), $filename);
            $request->employeePhoto = $filename;
        }

        DB::table('test_upload')->insert(
            ['name' => $request->name, 'employeePhoto' => $request->employeePhoto]
        );

        echo json_encode(['message'=> $request->name.' has been saved']);

//        return redirect(route('form.upload'));
    }
}

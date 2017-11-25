<?php

namespace App\Http\Controllers;

use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestUploadController extends Controller
{
    use GlobalUtils;

    public function upload(Request $request)
    {
        $request->validate(['name' => 'required', 'employeePhoto' => 'required']);

        /*Handle image uploads*/
        if ($request->hasFile('employeePhoto') && $request->file('employeePhoto')->isValid()) {
            $filename = $this->getFileName($request->employeePhoto);
            $request->employeePhoto->move(base_path('public/images'), $filename);
            $request->employeePhoto = $filename;
        }

        DB::table('test_upload')->insert(
            ['name' => $request->name, 'employeePhoto' => $request->employeePhoto]
        );

        echo json_encode(['message' => $request->name . ' has been saved']);

//        return redirect(route('form.upload'));
    }

    public function seedCalendar()
    {
        $months = ['JA', 'FB', 'MR', 'AP', 'MY', 'JN', 'JL', 'AG', 'SP', 'OC', 'NV', 'DC'];
        $dayNames = ['SU', 'M', 'TU', 'W', 'TH', 'F', 'SA'];
        $totalWorkers = 1;


        $cellIDs = array();

        for ($tw = 1; $tw <= $totalWorkers; $tw++) {
            foreach ($months as $m) {

                // JANUARY
                if ($m == 'JA') {
                    for ($w = 1; $w <= 5; $w++) {
                        foreach ($dayNames as $dayName) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['JA1SU', 'JA5TH', 'JA5F', 'JA5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }

                        }
                    }
                }

                if ($m == 'FB') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['FB1SU', 'FB1M', 'FB1TU', 'FB1W', 'FB5TH', 'FB5F', 'FB5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'MR') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['MR1SU', 'MR1M', 'MR1TU', 'MR1W'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }


                if ($m == 'AP') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['AP5TU', 'AP5W', 'AP5TH', 'AP5F', 'AP5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'MY') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['MY1SU', 'MY1M', 'MY5F', 'MY5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'JN') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['JN1SU', 'JN1M', 'JN1TU', 'JN1W', 'JN1TH'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }

                        }
                    }
                }

                if ($m == 'JL') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['JL5W', 'JL5TH', 'JL5F', 'JL5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'AG') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['AG1SU', 'AG1M', 'AG1TU', 'AG5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'SP') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 6; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['SP1SU', 'SP1M', 'SP1TU', 'SP1W', 'SP1TH', 'SP1F', 'SP6M', 'SP6TU', 'SP6W', 'SP6TH', 'SP6F', 'SP6SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'OC') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['OC1SU', 'OC5TH', 'OC5F', 'OC5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'NV') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['NV1SU', 'NV1M', 'NV1TU', 'NV1W', 'NV5SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 'DC') {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 6; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['DC1SU', 'DC1M', 'DC1TU', 'DC1W', 'DC1TH', 'DC1F', 'DC6TU', 'DC6W', 'DC6TH', 'DC6F', 'DC6SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }
            }
        }


        echo count($cellIDs);
        echo json_encode($cellIDs);
    }

    public function attdLogic()
    {



    }


    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }

    public function getMondaysOfThisYearAddBy($day)
    {
        $start_date = Carbon::parse('first day of January');
        $end_date = Carbon::parse('last day of December');
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if($date->isMonday()){
                $dates[] = $date->addDay($day)->format('d/m/Y');
            }
        }

        return $dates;
    }

    public function getSundaysOfThisYearAddBy($day)
    {
        $start_date = Carbon::parse('first day of January');
        $end_date = Carbon::parse('last day of December');
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if($date->isSunday()){
                $dates[] = $date->addDay($day)->format('d/m/Y');
            }
        }

        return $dates;
    }
}

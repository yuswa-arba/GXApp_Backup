<?php

namespace App\Http\Controllers;

use App\Attendance\Events\AndroidTest;
use App\Attendance\Events\EmployeeClocked;
use App\Attendance\Models\DayOffSchedule;
use App\Attendance\Models\Shifts;
use App\Attendance\Models\Slots;
use App\Employee\Models\MasterEmployee;
use App\Salary\Models\GeneralBonusesCuts;
use App\Salary\Models\SalaryBonusCutType;
use App\Traits\GlobalUtils;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $d = Carbon::createFromFormat('d/m/Y', '06/02/2017')->dayOfYear;
        $s = Carbon::createFromFormat('d/m/Y', '06/02/2017')->addDay(24)->toDayDateTimeString();
        echo $d;
    }


    public function getMondaysOfThisYearAddBy($day)
    {
        $start_date = Carbon::parse('first day of January');
        $end_date = Carbon::parse('last day of December');
        $dates = [];

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if ($date->isMonday()) {
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

        for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
            if ($date->isSunday()) {
                $dates[] = $date->addDay($day)->format('d/m/Y');
            }
        }

        return $dates;
    }

    public function tryLogic()
    {
        $maxLoopDay = 1;
        $workinDay = 6;
        $totalDaysInThisYear = (365 + Carbon::now()->format('L'));

        for ($i = 0; $i < $maxLoopDay; $i++) {

            $dayOffs = array();

            $slot = Slots::find(1); // GENERAL SLOT

            $w = 1;
            for ($d = $totalDaysInThisYear; $d > 7; $d -= 6) {
                $week = $w++;
                $date = Carbon::parse('first sunday of January')->addDays($i + ($workinDay + 1) * $week)->format('d/m/Y');

                // Check if date is in current year
                if (Carbon::createFromFormat('d/m/Y', $date)->year == Carbon::now()->year) {
                    array_push($dayOffs, array('slotId' => $slot->id, 'date' => $date, 'description' => 'Weekly Day Off'));
                }
            }

            // add first day off
            $firstDayOff = Carbon::parse('first sunday of January')->addDays($i)->format('d/m/Y');

            // Check if date is in current year
            if (Carbon::createFromFormat('d/m/Y', $firstDayOff)->year == Carbon::now()->year) {
                array_push($dayOffs, array('slotId' => $slot->id, 'date' => $firstDayOff, 'description' => 'Weekly Day Off'));
            }

            // add missing working days
            if ($i + 1 > $workinDay) {
                for ($m = $i + 1; $m > 0; $m -= $workinDay + 1) {

                    $date = Carbon::parse('first sunday of January')->addDays($m - 1);

                    if ($date->day != $i + 1) {
                        if (Carbon::createFromFormat('d/m/Y', $date->format('d/m/Y'))->year == Carbon::now()->year) {
                            array_push($dayOffs, array('slotId' => $slot->id, 'date' => $date->format('d/m/Y'), 'description' => 'Weekly Day Off'));
                        }
                    }
                }
            }

        }

        echo json_encode($dayOffs);

    }

    public function isTimeGT()
    {
        $start = Carbon::createFromFormat('H:i', '08:00');
        $end = Carbon::createFromFormat('H:i', '07:00');

        // check if its over night
        if ($start->gt($end)) {
            echo 'it\'s overnight';
        } else {
            echo 'it\'s not overnight';
        }
    }

    public function slotEmployeePivot()
    {
        $slots = Slots::all();
        $assignedSlots = array();

        foreach ($slots as $slot) {
            echo json_encode($slot->employees);
        }
    }

    public function employeeFromSlot()
    {
        $slot = Slots::find(4);
        echo json_encode($slot->employees);
    }

    public function generateDate()
    {
        $dates = $this->generateDateRange('01/01/2017', '13/01/2017', 'd/m/Y');
        foreach ($dates as $date) {

            echo $date . '<br>';

        }
    }

    public function broadcast()
    {
//        event(new EmployeeClocked(['name' => 'Kevin', 'age' => 21]));
//        broadcast(new EmployeeClocked(['name' => 'Kevin', 'age' => 21]))->toOthers();
        broadcast(new AndroidTest());
    }

    public function cbdiff()
    {
        $clockInTime = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y') . ' ' . '08:25');
        $shift = Shifts::find(1);
        $shiftWorkStartAt = Carbon::createFromFormat('d/m/Y H:i', Carbon::now()->format('d/m/Y') . ' ' . '08:00');

        // if its late then return minutes late
        if ($clockInTime->lt($shiftWorkStartAt)) {
            return $clockInTime->diffInMinutes($shiftWorkStartAt);
        }

        return 0;
    }

    public function dayoff()
    {
        $dayOffs = DayOffSchedule::select('date','description')->where('slotId', 1)->get();

        $copyOfDaysOffs = array();

        foreach ($dayOffs as $dayOff) {
            $dayOffDate = Carbon::createFromFormat('d/m/Y',$dayOff->date)->addDay()->format('d/m/Y');
            array_push($copyOfDaysOffs,array('slotId'=>2,'date'=>$dayOffDate,'description'=>$dayOff->description));
        }

        echo json_encode($copyOfDaysOffs);
    }

    public function pluck()
    {
        return GeneralBonusesCuts::all()->pluck('salaryBonusCutTypeId');
    }

    public function td()
    {
        return $this->totalDays('01/01/2018','5/01/2018');
    }





}

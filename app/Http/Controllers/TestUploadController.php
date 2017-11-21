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
        $months = 12;
        $weeks = 48;
        $days1 = 30;
        $days2 = 31;
        $dayNames = ['SU', 'M', 'T', 'W', 'TH', 'F', 'SA'];
        $totalWorkers = 1;


        $cellIDs = array();

        for ($tw = 1; $tw <= $totalWorkers; $tw++) {
            for ($m = 1; $m <= $months; $m++) {

                // JANUARY
                if ($m == 1) {
                    for ($w = 1; $w <= 5; $w++) {
                        foreach ($dayNames as $dayName) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['11SU', '15TH', '15F', '15SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }

                        }
                    }
                }

                if ($m == 2) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['21SU', '21M', '21T', '21W','25TH','25F','25SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 3) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            
                            // Filter dates
                            $filter = ['31SU', '31M', '31T', '31W'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }


                if ($m == 4) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            
                            // Filter dates
                            $filter = ['45T', '45W', '45TH','45F','45SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 5) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            
                            // Filter dates
                            $filter = ['51SU', '51M', '55F','55SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 6) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            
                            // Filter dates
                            $filter = ['61SU', '61M', '61T','61W','61TH'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                            
                        }
                    }
                }

                if ($m == 7) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            
                            // Filter dates
                            $filter = ['75W', '75TH', '75F','75SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 8) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['81SU', '81M', '81T','85SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 9) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 6; $w++) {
                            $id = $m . $w . $dayName;

                            // Filter dates
                            $filter = ['91SU','91M', '91T', '91W','91TH','91F','96M', '96T', '96W','96TH','96F','96SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 10) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['101SU','105TH','105F','105SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 11) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 5; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['111SU','111M','111T','111W','115SA'];

                            if (!in_array($id, $filter)) {
                                // if is not in filter dates then insert it
                                $id = $id . $tw;
                                array_push($cellIDs, $id);
                            }
                        }
                    }
                }

                if ($m == 12) {
                    foreach ($dayNames as $dayName) {
                        for ($w = 1; $w <= 6; $w++) {
                            $id = $m . $w . $dayName;
                            // Filter dates
                            $filter = ['121SU','121M','121T','121W','121TH','121F','126T','126W','126TH','126F','126SA'];

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
}

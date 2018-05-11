<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceValidationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Valid'],
            ['id'=>'2','name' => 'No Clock-In'],
            ['id'=>'3','name' => 'No Clock-Out'],
            ['id'=>'4','name' => 'Late Clock-In'],
            ['id'=>'5','name' => 'Early Clock-Out'],
            ['id'=>'6','name' => 'No Clock-In Location'],
            ['id'=>'7','name' => 'No Clock-Out Location'],
            ['id'=>'8','name' => 'No Clock-In Photo'],
            ['id'=>'9','name' => 'No Clock-Out Photo'],
            ['id'=>'10','name' => 'No Photo'],
            ['id'=>'11','name' => 'No Location'],
            ['id'=>'12','name' => 'Clocking Not Completed'],
            ['id'=>'98','name' => 'Manually Input'],
            ['id'=>'99','name' => 'Invalid'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('attendanceValidation')->get()->count() > 0) {
            DB::table('attendanceValidation')->truncate();
        }

        DB::table('attendanceValidation')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSettingTableSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            [
                'id'=>'1',
                'name' => 'allow-early-clock-out',
                'value'=>'0',
                'description'=>'Allow employee to clock out early (Value 1: yes, 0: no)',
            ],
            [
                'id'=>'2',
                'name' => 'max-leave-days',
                'value'=>'12',
                'description'=>'Max days employee able to paid leave',
            ],
            [
                'id'=>'3',
                'name' => 'max-streak-paid-leave',
                'value'=>'7',
                'description'=>'Max days employee can streak paid leave',
            ],

        );

        /* Truncate all the data before populating*/
        if (DB::table('attendanceSetting')->get()->count() > 0) {
            DB::table('attendanceSetting')->truncate();
        }

        DB::table('attendanceSetting')->insert($data);
    }

}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'id'=>'1',
                'name'=>'8to17',
                'workStartAt'=>'08:00',
                'workEndAt'=>'17:00',
                'breakStartAt'=>'12:00',
                'breakEndAt'=>'13:00',
                'isOvernight'=>'0',
            ]
        );

        /* Truncate all the data before populating*/
        if (DB::table('shifts')->get()->count() > 0) {
            DB::table('shifts')->truncate();
        }

        DB::table('shifts')->insert($data);
    }
}

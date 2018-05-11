<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Vacation'],
            ['id'=>'2','name' => 'Sick Leave'],
            ['id'=>'3','name' => 'Holiday Pay'],
            ['id'=>'4','name' => 'Medical Leave'],
            ['id'=>'5','name' => 'Personal Leave'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('leaveType')->get()->count() > 0) {
            DB::table('leaveType')->truncate();
        }

        DB::table('leaveType')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceApprovalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Manager Approved'],
            ['id'=>'2','name' => 'Microsoft Face API'],
            ['id'=>'3','name' => 'Edited by Manager'],
            ['id'=>'4','name' => 'Fingerspot'],
            ['id'=>'98','name' => 'Disapproved'],
            ['id'=>'99','name' => 'Need Approval']
        );

        /* Truncate all the data before populating*/
        if (DB::table('attendanceApproval')->get()->count() > 0) {
            DB::table('attendanceApproval')->truncate();
        }

        DB::table('attendanceApproval')->insert($data);
    }
}

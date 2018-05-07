<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveApprovalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Approved'],
            ['id'=>'2','name' => 'Disapproved'],
            ['id'=>'3','name' => 'Waiting for Approval'],
            ['id'=>'4','name' => 'Change Date'],
            ['id'=>'5','name' => 'Postponed'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('leaveApproval')->get()->count() > 0) {
            DB::table('leaveApproval')->truncate();
        }

        DB::table('leaveApproval')->insert($data);
    }
}

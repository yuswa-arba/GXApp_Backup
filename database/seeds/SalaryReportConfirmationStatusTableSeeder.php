<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryReportConfirmationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name'=>'Confirmed'],
            ['id'=>'2','name'=>'Unconfirmed'],
            ['id'=>'3','name'=>'Waiting for Confirmation'],
            ['id'=>'4','name'=>'Stage 1 Confirmed'],
            ['id'=>'5','name'=>'Stage 2 Confirmed'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('salaryReportConfirmationStatus')->get()->count() > 0) {
            DB::table('salaryReportConfirmationStatus')->truncate();
        }

        DB::table('salaryReportConfirmationStatus')->insert($data);
    }
}

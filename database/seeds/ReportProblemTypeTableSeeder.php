<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportProblemTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Other'],
            ['id' => '2', 'name' => 'Android Auth'],
            ['id' => '3', 'name' => 'Helpdesk AUth'],
            ['id' => '4', 'name' => 'Kiosk Unauthorized Access'],
            ['id' => '5', 'name' => 'Unable to identify face'],
            ['id' => '6', 'name' => 'Permission'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('reportProblemType')->get()->count() > 0) {
            DB::table('reportProblemType')->truncate();
        }

        DB::table('reportProblemType')->insert($data);
    }
}

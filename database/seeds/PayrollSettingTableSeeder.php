<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayrollSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'generate-salary-from-date', 'value' => '26', 'description' => 'Default start date of generate salary'],
            ['id' => '2', 'name' => 'generate-salary-to-date', 'value' => '23', 'description' => 'Default end date of generate salary'],
            ['id' => '3', 'name' => 'max-days-confirmation-salary-valid-stage', 'value' => '2', 'description' => 'Max days to confirm salary to receive salary in time'],
            ['id' => '4', 'name' => 'max-days-confirmation-salary-stage-1', 'value' => '10', 'description' => 'Max days to confirm salary (stage I) to receive salary in stage 1 schedule'],
            ['id' => '5', 'name' => 'delay-unconfirmed-salary-stage-1', 'value' => '10', 'description' => 'Delay days to receive salary on stage 1 salary confirmation'],
            ['id' => '6', 'name' => 'delay-unconfirmed-salary-stage-2', 'value' => '30', 'description' => 'Delay days to receive salary for unconfirmed salary'],
            ['id' => '7', 'name' => 'default-salary', 'value' => '2000000', 'description' => 'Default salary for employee'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('payrollSetting')->get()->count() > 0) {
            DB::table('payrollSetting')->truncate();
        }

        DB::table('payrollSetting')->insert($data);
    }
}

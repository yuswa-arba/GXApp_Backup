<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralBonusesCutsTableSeeder extends Seeder
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
                'id' => '1',
                'salaryBonusCutTypeId' => '2',
                'value' => '',
                'isUsingFormula' => '1',
                'formula' => '_day_absence_/25*_salary_',
                'isActive' => '1',
                'insertedDate' => '',
                'insertedBy' => '',
            ],
            [
                'id' => '2',
                'salaryBonusCutTypeId' => '3',
                'value' => '33000',
                'isUsingFormula' => '0',
                'formula' => '',
                'isActive' => '1',
                'insertedDate' => '',
                'insertedBy' => '',
            ], [
                'id' => '3',
                'salaryBonusCutTypeId' => '1',
                'value' => '',
                'isUsingFormula' => '1',
                'formula' => '_min_late_in_/25/8/60*_salary_',
                'isActive' => '1',
                'insertedDate' => '',
                'insertedBy' => '',
            ], [
                'id' => '4',
                'salaryBonusCutTypeId' => '4',
                'value' => '',
                'isUsingFormula' => '1',
                'formula' => '_min_early_out_/25/8/60*_salary_',
                'isActive' => '0',
                'insertedDate' => '',
                'insertedBy' => '',
            ],
        );

        /* Truncate all the data before populating*/
        if (DB::table('generalBonusesCuts')->get()->count() > 0) {
            DB::table('generalBonusesCuts')->truncate();
        }

        DB::table('generalBonusesCuts')->insert($data);
    }
}

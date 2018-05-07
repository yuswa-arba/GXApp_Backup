<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaryBonusCutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Late Deduction', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '2', 'name' => 'Absence Deduction', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '3', 'name' => 'BPJS Deduction', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '4', 'name' => 'Early Clock Out Deduction', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '5', 'name' => 'Clock In/Out Empty', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '6', 'name' => 'Cooperatives Deduction', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '7', 'name' => 'Attendance Bonus', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '1'],
            ['id' => '8', 'name' => 'Skill Bonus', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '9', 'name' => 'Position Bonus', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '10', 'name' => 'Closing Ticket Bonus', 'addOrSub' => 'add', 'isRelatedToDivision' => '1', 'divisionId' => '1', 'isDeleted' => '0'],
            ['id' => '11', 'name' => 'Attendance Bonus', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '12', 'name' => 'Postponed Salary Add', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '13', 'name' => 'Postponed Salary Sub', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '14', 'name' => 'Disputed Salary Add', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '15', 'name' => 'Disputed Salary Sub', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '16', 'name' => 'Manual Add', 'addOrSub' => 'add', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
            ['id' => '17', 'name' => 'Manual Sub', 'addOrSub' => 'sub', 'isRelatedToDivision' => '0', 'divisionId' => '', 'isDeleted' => '0'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('salaryBonusCutType')->get()->count() > 0) {
            DB::table('salaryBonusCutType')->truncate();
        }

        DB::table('salaryBonusCutType')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Active'],
            ['name' => 'Resigned'],
            ['name' => 'Sick'],
            ['name' => 'Absent'],
            ['name' => 'Paid leave']);

        /* Truncate all the data before populating*/
        if (DB::table('employeeStatus')->get()->count() > 0) {
            DB::table('employeeStatus')->truncate();
        }

        DB::table('employeeStatus')->insert($data);
    }
}

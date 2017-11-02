<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Household Trainee'],
            ['name' => 'Storage Trainee'],
            ['name' => 'Technician Trainee'],
            ['name' => 'Customer Service Trainee'],
            ['name' => 'Marketing Trainee'],
            ['name' => 'Network Administrator Trainee'],
            ['name' => 'Security Officer'],
            ['name' => 'Food Service Officer'],
            ['name' => 'Cleaning Service Officer'],
            ['name' => 'Stock Clerk'],
            ['name' => 'Customer Technical Service Officer'],
            ['name' => 'Junior Technical Officer'],
            ['name' => 'Senior Technical Officer'],
            ['name' => 'Telemarketing Officer'],
            ['name' => 'Junior Sales Representative'],
            ['name' => 'Senior Sales Representative'],
            ['name' => 'Network Administrator'],
            ['name' => 'Inventory Executive'],
            ['name' => 'Chief Knowledge Officer'],
            ['name' => 'Chief Technical Officer'],
            ['name' => 'Senior Network Administrator'],
            ['name' => 'Chief Network Administrator'],
            ['name' => 'Chief Brand Officer'],
            ['name' => 'Chief Audit Executive'],
            ['name' => 'Chief Design Officer'],
            ['name' => 'Chief Financial Officer'],
            ['name' => 'Chief Operating Officer'],
            ['name' => 'Chief Executive Officer']
        );

        /* Truncate all the data before populating*/
        if (DB::table('jobPositions')->get()->count() > 0) {
            DB::table('jobPositions')->truncate();
        }

        DB::table('jobPositions')->insert($data);
    }
}

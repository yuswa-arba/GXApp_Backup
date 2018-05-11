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
            ['id'=>'1','name' => 'Household Trainee'],
            ['id'=>'2','name' => 'Storage Trainee'],
            ['id'=>'3','name' => 'Technician Trainee'],
            ['id'=>'4','name' => 'Customer Service Trainee'],
            ['id'=>'5','name' => 'Marketing Trainee'],
            ['id'=>'6','name' => 'Network Administrator Trainee'],
            ['id'=>'7','name' => 'Security Officer'],
            ['id'=>'8','name' => 'Food Service Officer'],
            ['id'=>'9','name' => 'Cleaning Service Officer'],
            ['id'=>'10','name' => 'Stock Clerk'],
            ['id'=>'11','name' => 'Customer Technical Service Officer'],
            ['id'=>'12','name' => 'Junior Technical Officer'],
            ['id'=>'13','name' => 'Senior Technical Officer'],
            ['id'=>'14','name' => 'Telemarketing Officer'],
            ['id'=>'15','name' => 'Junior Sales Representative'],
            ['id'=>'16','name' => 'Senior Sales Representative'],
            ['id'=>'17','name' => 'Network Administrator'],
            ['id'=>'18','name' => 'Inventory Executive'],
            ['id'=>'19','name' => 'Chief Knowledge Officer'],
            ['id'=>'20','name' => 'Chief Technical Officer'],
            ['id'=>'21','name' => 'Senior Network Administrator'],
            ['id'=>'22','name' => 'Chief Network Administrator'],
            ['id'=>'23','name' => 'Chief Brand Officer'],
            ['id'=>'24','name' => 'Chief Audit Executive'],
            ['id'=>'25','name' => 'Chief Design Officer'],
            ['id'=>'26','name' => 'Chief Financial Officer'],
            ['id'=>'27','name' => 'Chief Operating Officer'],
            ['id'=>'28','name' => 'Chief Executive Officer']
        );

        /* Truncate all the data before populating*/
        if (DB::table('jobPositions')->get()->count() > 0) {
            DB::table('jobPositions')->truncate();
        }

        DB::table('jobPositions')->insert($data);
    }
}

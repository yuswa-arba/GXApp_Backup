<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecruitmentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Training'],
            ['id'=>'2','name' => 'Internship'],
            ['id'=>'3','name' => 'Freelance'],
            ['id'=>'4','name' => 'Contracted'],
            ['id'=>'5','name' => 'Permanent']
        );

        /* Truncate all the data before populating*/
        if (DB::table('recruitmentStatus')->get()->count() > 0) {
            DB::table('recruitmentStatus')->truncate();
        }

        DB::table('recruitmentStatus')->insert($data);
    }
}

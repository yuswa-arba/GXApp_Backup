<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReligionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Christianity'],
            ['id'=>'2','name' => 'Islam'],
            ['id'=>'3','name' => 'Catholicism'],
            ['id'=>'4','name' => 'Buddhism'],
            ['id'=>'5','name' => 'Hinduism'],
            ['id'=>'6','name'=>'Atheist']
        );

        /* Truncate all the data before populating*/
        if (DB::table('religions')->get()->count() > 0) {
            DB::table('religions')->truncate();
        }

        DB::table('religions')->insert($data);
    }
}

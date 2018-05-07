<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id'=>'1','name' => 'Married'],
            ['id'=>'2','name' => 'Remarried'],
            ['id'=>'3','name' => 'Divorced'],
            ['id'=>'4','name' => 'Widowed'],
            ['id'=>'5','name' => 'Unmarried']
        );

        /* Truncate all the data before populating*/
        if (DB::table('maritalStatus')->get()->count() > 0) {
            DB::table('maritalStatus')->truncate();
        }

        DB::table('maritalStatus')->insert($data);
    }
}

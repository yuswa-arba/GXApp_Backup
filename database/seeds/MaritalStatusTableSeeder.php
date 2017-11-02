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
            ['name' => 'Married'],
            ['name' => 'Remarried'],
            ['name' => 'Divorced'],
            ['name' => 'Widowed'],
            ['name' => 'Unmarried']
        );

        /* Truncate all the data before populating*/
        if (DB::table('maritalStatus')->get()->count() > 0) {
            DB::table('maritalStatus')->truncate();
        }

        DB::table('maritalStatus')->insert($data);
    }
}

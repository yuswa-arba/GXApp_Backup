<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageItemTestStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Tested'],
            ['id' => '2', 'name' => 'Untested'],
            ['id' => '3', 'name' => 'No Need'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('storageItemTestStatus')->get()->count() > 0) {
            DB::table('storageItemTestStatus')->truncate();
        }

        DB::table('storageItemTestStatus')->insert($data);
    }
}

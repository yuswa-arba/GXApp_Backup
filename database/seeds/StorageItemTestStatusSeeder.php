<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageItemTestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'No Need'],
            ['name' => 'Untested'],
            ['name' => 'Tested']
        );

        /* Truncate all the data before populating*/
        if (DB::table('storageItemTestStatus')->get()->count() > 0) {
            DB::table('storageItemTestStatus')->truncate();
        }

        DB::table('storageItemTestStatus')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageItemStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Available'],
            ['id' => '2', 'name' => 'Out of Stock'],
            ['id' => '3', 'name' => 'Running out'],
            ['id' => '4', 'name' => 'Unavailable'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('storageItemStatus')->get()->count() > 0) {
            DB::table('storageItemStatus')->truncate();
        }

        DB::table('storageItemStatus')->insert($data);
    }
}

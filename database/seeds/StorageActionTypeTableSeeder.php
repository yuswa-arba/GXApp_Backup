<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageActionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Moving'],
            ['id' => '2', 'name' => 'Sell'],
            ['id' => '3', 'name' => 'Use'],
        );

        /* Truncate all the data before populating*/
        if (DB::table('storageActionType')->get()->count() > 0) {
            DB::table('storageActionType')->truncate();
        }

        DB::table('storageActionType')->insert($data);
    }
}

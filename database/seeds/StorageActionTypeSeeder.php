<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageActionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['name' => 'Moving'],
            ['name' => 'Sell'],
            ['name' => 'Use']
        );

        /* Truncate all the data before populating*/
        if (DB::table('storageActionType')->get()->count() > 0) {
            DB::table('storageActionType')->truncate();
        }

        DB::table('storageActionType')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageItemTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['code' => 'C', 'name' => 'Consumable','isDeleted'=>0],
            ['code' => 'D', 'name' => 'Durable','isDeleted'=>0],

        );

        /* Truncate all the data before populating*/
        if (DB::table('storageItemTypes')->get()->count() > 0) {
            DB::table('storageItemTypes')->truncate();
        }

        DB::table('storageItemTypes')->insert($data);
    }
}

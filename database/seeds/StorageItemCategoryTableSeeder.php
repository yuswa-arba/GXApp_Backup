<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageItemCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['code' => 'A', 'name' => 'Advertising', 'isDeleted' => '0'],
            ['code' => 'B', 'name' => 'Appliances', 'isDeleted' => '0'],
            ['code' => 'C', 'name' => 'Architecture', 'isDeleted' => '0'],
            ['code' => 'D', 'name' => 'Beverages', 'isDeleted' => '0'],
            ['code' => 'E', 'name' => 'Cleaning', 'isDeleted' => '0'],
            ['code' => 'F', 'name' => 'Electronics', 'isDeleted' => '0'],
            ['code' => 'G', 'name' => 'Food', 'isDeleted' => '0'],
            ['code' => 'H', 'name' => 'Furniture', 'isDeleted' => '0'],
            ['code' => 'I', 'name' => 'Infrastructure', 'isDeleted' => '0'],
            ['code' => 'J', 'name' => 'Kitchen', 'isDeleted' => '0'],
            ['code' => 'K', 'name' => 'Networking', 'isDeleted' => '0'],
            ['code' => 'L', 'name' => 'Office', 'isDeleted' => '0'],
            ['code' => 'M', 'name' => 'Other', 'isDeleted' => '0'],
            ['code' => 'N', 'name' => 'Tools', 'isDeleted' => '0'],
            ['code' => 'O', 'name' => 'Uniform', 'isDeleted' => '0'],
            ['code' => 'P', 'name' => 'Vehicles', 'isDeleted' => '0']

        );

        /* Truncate all the data before populating*/
        if (DB::table('storageItemCategory')->get()->count() > 0) {
            DB::table('storageItemCategory')->truncate();
        }

        DB::table('storageItemCategory')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoragePurchaseOrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Open'],
            ['id' => '2', 'name' => 'Closed'],
            ['id' => '3', 'name' => 'Pending'],
            ['id' => '4', 'name' => 'Canceled'],


        );

        /* Truncate all the data before populating*/
        if (DB::table('storagePurchaseOrderStatus')->get()->count() > 0) {
            DB::table('storagePurchaseOrderStatus')->truncate();
        }

        DB::table('storagePurchaseOrderStatus')->insert($data);
    }
}

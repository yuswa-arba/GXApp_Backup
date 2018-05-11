<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageWarehousesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            [
                'id' => '1',
                'name' => 'GlobalXtreme Bali',
                'address' => 'Jl. Raya Kerobokan 388x',
                'country' => 'Indonesia',
                'city' => 'Kuta Utara, Bali',
                'postalCode' => '80361',
                'phoneNumber' => '(0361) 736811',
                'isDeleted' => '0',
            ]
        );

        /* Truncate all the data before populating*/
        if (DB::table('storageWarehouses')->get()->count() > 0) {
            DB::table('storageWarehouses')->truncate();
        }

        DB::table('storageWarehouses')->insert($data);
    }
}

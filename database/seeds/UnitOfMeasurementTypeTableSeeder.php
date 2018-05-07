<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitOfMeasurementTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'Area'],
            ['id' => '2', 'name' => 'Length'],
            ['id' => '3', 'name' => 'Mass'],
            ['id' => '4', 'name' => 'Volume'],
            ['id' => '5', 'name' => 'Quantity'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('unitOfMeasurementType')->get()->count() > 0) {
            DB::table('unitOfMeasurementType')->truncate();
        }

        DB::table('unitOfMeasurementType')->insert($data);
    }
}

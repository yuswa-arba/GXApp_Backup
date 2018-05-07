<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitOfMeasurementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'format' => 'g', 'description' => 'gram(s)', 'unitOfMeasurementTypeId' => '3', 'isDeleted' => '0'],
            ['id' => '2', 'format' => 'mm', 'description' => 'milimeter(s)', 'unitOfMeasurementTypeId' => '2', 'isDeleted' => '0'],
            ['id' => '3', 'format' => 'ea', 'description' => 'each', 'unitOfMeasurementTypeId' => '5', 'isDeleted' => '0'],
            ['id' => '4', 'format' => 'm', 'description' => 'meter(s)', 'unitOfMeasurementTypeId' => '2', 'isDeleted' => '0'],


        );

        /* Truncate all the data before populating*/
        if (DB::table('unitOfMeasurements')->get()->count() > 0) {
            DB::table('unitOfMeasurements')->truncate();
        }

        DB::table('unitOfMeasurements')->insert($data);
    }
}

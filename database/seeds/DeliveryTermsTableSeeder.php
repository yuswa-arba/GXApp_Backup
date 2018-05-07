<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryTermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            ['id' => '1', 'name' => 'EXW', 'description' => 'ex works, Location: location of the factory'],
            ['id' => '2', 'name' => 'FCA', 'description' => 'free carrier, Location: agreed location'],
            ['id' => '3', 'name' => 'CPT', 'description' => 'carriage paid to, Location: agreed place of destination'],
            ['id' => '4', 'name' => 'CIP', 'description' => 'carriage and insurance paid, Location: agreed place of destination'],
            ['id' => '5', 'name' => 'DAF', 'description' => 'delivered at frontier, Location: agreed place of delivery at the frontier'],
            ['id' => '6', 'name' => 'DDU', 'description' => 'delivered duty unpaid, Location: agreed place of destination in the importing country'],
            ['id' => '7', 'name' => 'DDP', 'description' => 'delivered duty paid, Location: agreed place of destination in the importing country'],
            ['id' => '8', 'name' => 'XXX', 'description' => 'others, Location : agreement in contract'],

        );

        /* Truncate all the data before populating*/
        if (DB::table('deliveryTerms')->get()->count() > 0) {
            DB::table('deliveryTerms')->truncate();
        }

        DB::table('deliveryTerms')->insert($data);
    }
}

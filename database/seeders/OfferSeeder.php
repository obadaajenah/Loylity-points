<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("offers")->insert([
            'name' => 'T-Shirt small size',
            'partner_id' => 1,
            'segmentation_id' => 3,
            'value' => 45,
            'quantity' => 4
        ]);
    }
}

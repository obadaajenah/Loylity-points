<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bundle;

class BundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("bundles")->insert([
            'name' => '1M1',
            'price' => 100,
            'bonus' => 100,
            'gems' => 10,
            'expiration_period' => 30,
            'golden_offers_number' => 2,
            'silver_offers_number' => 5,
            'bronze_offers_number' => 10,
            'new_offers_number' => 20
        ]);
        DB::table("bundles")->insert([
            'name' => '1M2',
            'price' => 200,
            'bonus' => 200,
            'gems' => 25,
            'expiration_period' => 30,
            'golden_offers_number' => 5,
            'silver_offers_number' => 10,
            'bronze_offers_number' => 20,
            'new_offers_number' => 40
        ]);
        DB::table("bundles")->insert([
            'name' => '3M1',
            'price' => 400,
            'bonus' => 650,
            'gems' => 80,
            'expiration_period' => 90,
            'golden_offers_number' => 15,
            'silver_offers_number' => 30,
            'bronze_offers_number' => 65,
            'new_offers_number' => 125
        ]);
    }
}

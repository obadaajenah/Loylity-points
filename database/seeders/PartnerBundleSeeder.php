<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerBundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partner_bundles')->insert([
            'partner_id' => 1,
            'bundle_id' => 1,
            'price' => 100,
            'golden_offers_number' => 15,
            'silver_offers_number' => 30,
            'bronze_offers_number' => 65,
            'new_offers_number' => 125,
            'start_date' => '2023-06-01',
            'end_date' => '2023-07-01'    
        ]);
        DB::table('partner_bundles')->insert([
            'partner_id' => 1,
            'bundle_id' => 1,
            'price' => 100,
            'golden_offers_number' => 15,
            'silver_offers_number' => 30,
            'bronze_offers_number' => 65,
            'new_offers_number' => 125,
            'start_date' => '2023-07-01',
            'end_date' => '2023-08-01'    
        ]);
    }
}

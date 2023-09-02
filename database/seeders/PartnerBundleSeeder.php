<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartnerBundle;

class PartnerBundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartnerBundle::create([
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
        PartnerBundle::create([
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
        PartnerBundle::create([
            'partner_id' => 1,
            'bundle_id' => 3,
            'price' => 400,
            'golden_offers_number' => 15,
            'silver_offers_number' => 30,
            'bronze_offers_number' => 65,
            'new_offers_number' => 125,
            'start_date' => '2023-08-04',
            'end_date' => '2023-11-03'    
        ]);
    }
}

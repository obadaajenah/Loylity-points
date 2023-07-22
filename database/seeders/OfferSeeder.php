<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::create([
            'name' => 'T-Shirt small size',
            'partner_id' => 1,
            'segmentation_id' => 1,
            'valueInBonus' => 45,
            'quantity' => 4
        ]);
        Offer::create([
            'name' => 'Runner',
            'partner_id' => 2,
            'segmentation_id' => 2,
            'valueInBonus' => 45,
            'quantity' => 4
        ]);
        Offer::create([
            'name' => 'Smart Sport Wash',
            'partner_id' => 1,
            'segmentation_id' => 3,
            'valueInBonus' => 45,
            'quantity' => 4
        ]);
        Offer::Create([
            'name' => 'Handbag',
            'partner_id' => 2,
            'segmentation_id' => 4,
            'valueInBonus' => 45,
            'quantity' => 4
        ]);
    }
}

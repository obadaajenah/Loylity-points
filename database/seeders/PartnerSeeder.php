<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::create([
            'user_id' => 2,
            'gems' => 100,
            'bonus' => 100
        ]);
        Partner::create([
            'user_id' => 4,
            'gems' => 500,
            'bonus' => 2500
        ]);
    }
}

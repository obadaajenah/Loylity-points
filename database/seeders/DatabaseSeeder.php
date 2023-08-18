<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(DefaultValueSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PartnerSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(BundleSeeder::class);
        $this->call(PartnerBundleSeeder::class);
        $this->call(OfferSeeder::class);
        $this->call(BonusTransferSeeder::class);
    }
}

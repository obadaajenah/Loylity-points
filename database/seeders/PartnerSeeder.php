<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("partners")->insert([
            // 'id' => 1,
            'user_id' => 2,
            'gems' => 100,
            'bonus' => 100
        ]);
    }
}

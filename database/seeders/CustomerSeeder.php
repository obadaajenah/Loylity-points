<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("customers")->insert([
            'id' => 1,
            'user_id' => 3,
            'segmentation_id' => 4,
            'nickName' => 'SparkAO4',
            'cur_bonus' => 0,
            'total_bonus' => 0,
            'cur_gems' => 0,
            'total_gems' => 0,
        ]);
    }
}

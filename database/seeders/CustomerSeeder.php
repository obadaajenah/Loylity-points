<?php

namespace Database\Seeders;

use App\Http\Controllers\BonusTransferController;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'user_id' => 3,
            'segmentation_id' => 1,
            'nickName' => 'SparkAO4',
            'cur_bonus' => 100,
            'total_bonus' => 100,
            'cur_gems' => 0,
            'total_gems' => 0,
        ]);
        Customer::create([
            'user_id' => 5,
            'segmentation_id' => 4,
            // 'nickName' => 'SparkAO4',
            'cur_bonus' => 100,
            'total_bonus' => 100,
            'cur_gems' => 0,
            'total_gems' => 0,
        ]);
        Customer::create([
            'user_id' => 6,
            'segmentation_id' => 3,
            // 'nickName' => 'SparkAO4',
            'cur_bonus' => 100,
            'total_bonus' => 100,
            'cur_gems' => 0,
            'total_gems' => 0,
        ]);
        Customer::create([
            'user_id' => 7,
            'segmentation_id' => 2,
            // 'nickName' => 'SparkAO4',
            'cur_bonus' => 100,
            'total_bonus' => 100,
            'cur_gems' => 0,
            'total_gems' => 0,
        ]);
        Customer::create([
            'user_id' => 8,
            'segmentation_id' => 4,
            // 'nickName' => 'SparkAO4',
            'cur_bonus' => 100,
            'total_bonus' => 100,
            'cur_gems' => 0,
            'total_gems' => 0,
        ]);
    }
}

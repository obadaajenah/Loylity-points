<?php

namespace Database\Seeders;

use App\Models\BonusTransfer;
use Illuminate\Database\Seeder;
use DateTime;

class BonusTransferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BonusTransfer::create([
            'sender_user_id' => 1,
            'receiver_user_id' => 3,
            'value' => 100,
            'type' => 'A2C',
            'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
        ]);
        BonusTransfer::create([
            'sender_user_id' => 1,
            'receiver_user_id' => 5,
            'value' => 100,
            'type' => 'A2C',
            'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
        ]);
        BonusTransfer::create([
            'sender_user_id' => 1,
            'receiver_user_id' => 6,
            'value' => 100,
            'type' => 'A2C',
            'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
        ]);
        BonusTransfer::create([
            'sender_user_id' => 1,
            'receiver_user_id' => 7,
            'value' => 100,
            'type' => 'A2C',
            'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
        ]);
        BonusTransfer::create([
            'sender_user_id' => 1,
            'receiver_user_id' => 8,
            'value' => 100,
            'type' => 'A2C',
            'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
        ]);
    }
}

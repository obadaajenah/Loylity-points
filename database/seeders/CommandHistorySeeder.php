<?php

namespace Database\Seeders;

use App\Models\CommandHistory;
use Illuminate\Database\Seeder;

class CommandHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommandHistory::create([
            'command_name' => 'bundleExpirationCommand',
            'action' => 'expire bundle  (1M1)  :  Magilla' ,
            'value' => "Deactived"
        ]);
        CommandHistory::create([
            'command_name' => 'bundleExpirationCommand',
            'action' => 'expire bundle  (3M2)  :  Addidas' ,
            'value' => "Deactived"
        ]);
        CommandHistory::create([
            'command_name' => 'bonusExpirationCommand',
            'action' => 'expire bonus  (100)  :  ' . "Mhd Alaa Olabi",
            'value' => 150
        ]);
        CommandHistory::create([
            'command_name' => 'bonusExpirationCommand',
            'action' => 'expire bonus  (40)  :  ' . "fouad tohma",
            'value' => 320
        ]);
    }
}

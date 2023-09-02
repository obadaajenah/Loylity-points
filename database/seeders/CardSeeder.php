<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Card;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        Card::create([
            'account_id'=>1,
            'card_number'=> '1111111111111111',
            'secret_key' => Hash::make('0000')
        ]);
        Card::create([
            'account_id'=>2,
            'card_number'=> '9760120104308207',
            'secret_key' => Hash::make('0000')
        ]);
        Card::create([
            'account_id'=>3,
            'card_number'=> '1001200230034004',
            'secret_key' => Hash::make('0000')
        ]);

        for($i=4;$i<=250;$i++){
            Card::create([
                'account_id'=>$i,
                'card_number'=> substr(str_shuffle(str_repeat($x='0123456789',16)),0,16),
                'secret_key' => Hash::make('0000')
            ]);
        }
    }
}

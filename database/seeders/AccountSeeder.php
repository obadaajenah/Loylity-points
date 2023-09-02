<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create(['balance' => 30000]);
        for($i=1;$i<=249;$i++){
            Account::create(['balance' => 300]);            
        }
    }
}

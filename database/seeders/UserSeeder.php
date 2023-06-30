<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            'id' => 2,
            'fname' => 'Magilla',
            'lname' => '',
            'role_id' => 2,
            'email' => 'magilla@gmail.com',
            // 'phone_number' => '',
            'password' => hash::make('12345678'),
        ]);
        DB::table("users")->insert([
            'id' => 3,
            'fname' => 'Mhd Alaa',
            'lname' => 'Olabi',
            'role_id' => 3,
            // 'email' => 'magilla@gmail.com',
            'phone_number' => '963965695776',
            'password' => hash::make('alaa1234'),
        ]);
    }
}

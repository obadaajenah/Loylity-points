<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::Create([
            'fname' => 'Magilla',
            'lname' => '',
            'role_id' => 2,
            'email' => 'magilla@gmail.com',
            // 'phone_number' => '',
            'password' => hash::make('12345678'),
        ]);
        User::Create([
            'fname' => 'Mhd Alaa',
            'lname' => 'Olabi',
            'role_id' => 3,
            // 'email' => 'magilla@gmail.com',
            'phone_number' => '963965695776',
            'password' => hash::make('alaa1234'),
        ]);
        User::Create([            
            'fname' => 'puma',
            'lname' => '',
            'role_id' => 2,
            'email' => 'puma@gmail.com',
            // 'phone_number' => '963965695776',
            'password' => hash::make('puma1234'),
        ]);
        User::Create([            
            'fname' => 'fouad',
            'lname' => '',
            'role_id' => 3,
            // 'email' => 'puma@gmail.com',
            'phone_number' => '5555555555',
            'password' => hash::make('12345678'),
        ]);
        User::Create([            
            'fname' => 'farouq',
            'lname' => '',
            'role_id' => 3,
            // 'email' => 'puma@gmail.com',
            'phone_number' => '6666666666',
            'password' => hash::make('12345678'),
        ]);
        User::Create([            
            'fname' => 'firas',
            'lname' => '',
            'role_id' => 3,
            // 'email' => 'puma@gmail.com',
            'phone_number' => '7777777777',
            'password' => hash::make('12345678'),
        ]);
        User::Create([            
            'fname' => 'farah',
            'lname' => '',
            'role_id' => 3,
            // 'email' => 'puma@gmail.com',
            'phone_number' => '8888888888',
            'password' => hash::make('12345678'),
        ]);
    }
}

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
            'password' => hash::make('12345678'),
            'img_url' => 'uploads/users/magilla.jpg'
        ]);
        User::Create([
            'fname' => 'Mhd Alaa',
            'lname' => 'Olabi',
            'role_id' => 3,
            'phone_number' => '+963965695776',
            'password' => hash::make('alaa1234'),
        ]);
        User::Create([            
            'fname' => 'puma',
            'lname' => '',
            'role_id' => 2,
            'email' => 'puma@gmail.com',
            'password' => hash::make('puma1234'),
            'img_url' => 'uploads/users/puma.png'
        ]);
        User::Create([            
            'fname' => 'fouad',
            'lname' => '',
            'role_id' => 3,
            'phone_number' => '+9635555555555',
            'password' => hash::make('12345678'),
        ]);
        User::Create([            
            'fname' => 'farouq',
            'lname' => '',
            'role_id' => 3,
            'phone_number' => '+9636666666666',
            'password' => hash::make('12345678'),
        ]);
        User::Create([            
            'fname' => 'firas',
            'lname' => '',
            'role_id' => 3,
            'phone_number' => '+9637777777777',
            'password' => hash::make('12345678'),
        ]);
        User::Create([            
            'fname' => 'farah',
            'lname' => '',
            'role_id' => 3,
            'phone_number' => '+9638888888888',
            'password' => hash::make('12345678'),
        ]);
    }
}

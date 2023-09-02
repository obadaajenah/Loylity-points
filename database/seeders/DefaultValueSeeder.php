<?php

namespace Database\Seeders;

use App\Models\DefaultValue;
use Illuminate\Database\Seeder;

class DefaultValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultValue::create([
            'name' => 'B2G',
            'value' => 100
        ]);
        DefaultValue::create([
            'name' => 'G2$',
            'value' => 12.5
        ]);
        DefaultValue::create([
            'name' => 'profit',
            'value' => 0.1
        ]);
    }
}

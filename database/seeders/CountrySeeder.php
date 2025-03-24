<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name'       => 'Myanmar',
                'created_at' => now(),
            ],
            [
                'name'       => 'USA',
                'created_at' => now(),
            ],
            [
                'name'       => 'Thai',
                'created_at' => now(),
            ],
            [
                'name'       => 'China',
                'created_at' => now(),
            ],
        ];

        Country::insert($countries);
    }
}

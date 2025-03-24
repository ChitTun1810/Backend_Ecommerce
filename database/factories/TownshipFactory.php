<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Township>
 */
class TownshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() : array
    {
        return [
            'city_id'      => 1,
            'name'         => 'Ahlone (အလုံ)',
            'delivery_fee' => 3000,
        ];
    }
}

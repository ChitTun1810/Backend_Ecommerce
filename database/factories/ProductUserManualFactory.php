<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductUserManual>
 */
class ProductUserManualFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "link"       => $this->faker->url,
            "title"      => $this->faker->title,
            "product_id" => $this->faker->numberBetween(1, 20),
        ];
    }
}

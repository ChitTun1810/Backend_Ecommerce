<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::isParent()->inRandomOrder()->limit(10)->first();
        return [
            'name'            => fake()->name(),
            'sku'             => fake()->name(),
            'stocks'          => 10,
            'brand_id'        => Brand::inRandomOrder()->first('id'),
            'category_id'     => $category->id,
            'price'           => 35,
            'country_id'      => 1,
            'is_active'       => 1,
            'product_type_id' => $category->productTypes()->inRandomOrder()->first('id'),
            'is_new_arrival'  => rand(0, 1),
        ];
    }
}

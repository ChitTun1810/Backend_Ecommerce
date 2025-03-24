<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productTypes = [
            [
                "name"        => "Red",
                "category_id" => 1,
                "created_at"  => now(),
            ],
            [
                "name"        => "Green",
                "category_id" => 2,
                "created_at"  => now(),
            ],
            [
                "name"        => "White",
                "category_id" => 3,
                "created_at"  => now(),
            ],
            [
                "name"        => "Black",
                "category_id" => 4,
                "created_at"  => now(),
            ],
            [
                "name"        => "Blue",
                "category_id" => 5,
                "created_at"  => now(),
            ],
            [
                "name"        => "Yellow",
                "category_id" => 6,
                "created_at"  => now(),
            ],
        ];

        ProductType::insert($productTypes);
    }
}

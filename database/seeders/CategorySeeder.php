<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id'         => 1,
                'name'       => 'Bedroom Linens & Accessories',
                'created_at' => now(),
            ],

            [
                'id'         => 2,
                'name'       => 'Buffet & Banquet',
                'created_at' => now(),
            ],

            [
                'id'         => 3,
                'name'       => 'F&B Solutions',
                'created_at' => now(),

            ],

            [
                'id'         => 4,
                'name'       => 'Food Services',
                'created_at' => now(),

            ],

            [
                'id'         => 5,
                'name'       => 'Housekeeping & Hygiene',
                'created_at' => now(),

            ],

            [
                'id'         => 6,
                'name'       => 'Kitchen Services',
                'created_at' => now(),

            ],

            [
                'id'         => 7,
                'name'       => 'Kitchen Utensils',
                'created_at' => now(),

            ],

            [
                'id'         => 8,
                'name'       => 'Professional Laundry System',
                'created_at' => now(),

            ],

            [
                'id'         => 9,
                'name'       => 'Tableware & Glassware',
                'created_at' => now(),

            ],

        ];

        $subCategories = [
            [
                'id'         => 10,
                'name'       => 'Bathroom Linens',
                'parent_id'  => 1,
                'created_at' => now(),
            ],
            [
                'id'         => 12,
                'name'       => 'Bedroom Linens',
                'parent_id'  => 1,
                'created_at' => now(),
            ],
            [
                'id'         => 13,
                'name'       => 'F & B Linens',
                'parent_id'  => 1,
                'created_at' => now(),
            ],
            [
                'id'         => 14,
                'name'       => 'In-room Accessories & Amenities',
                'parent_id'  => 1,
                'created_at' => now(),
            ],
            [
                'id'         => 15,
                'name'       => 'Buffet Ware',
                'parent_id'  => 2,
                'created_at' => now(),
            ],
            [
                'id'         => 16,
                'name'       => 'Chairs',
                'parent_id'  => 2,
                'created_at' => now(),
            ],
            [
                'id'         => 17,
                'name'       => 'Post',
                'parent_id'  => 2,
                'created_at' => now(),
            ],
            [
                'id'         => 18,
                'name'       => 'Stage & Floor',
                'parent_id'  => 2,
                'created_at' => now(),
            ],
            [
                'id'         => 19,
                'name'       => 'Table',
                'parent_id'  => 2,
                'created_at' => now(),
            ],
            [
                'id'         => 20,
                'name'       => 'Coffee Products',
                'parent_id'  => 3,
                'created_at' => now(),
            ],
            [
                'id'         => 21,
                'name'       => 'Gelato',
                'parent_id'  => 3,
                'created_at' => now(),
            ],
            [
                'id'         => 22,
                'name'       => 'Meat & Fish',
                'parent_id'  => 3,
                'created_at' => now(),
            ],
            [
                'id'         => 23,
                'name'       => 'Wine & Liquor',
                'parent_id'  => 3,
                'created_at' => now(),
            ],
            [
                'id'         => 24,
                'name'       => 'Bar Equipment',
                'parent_id'  => 4,
                'created_at' => now(),
            ],
            [
                'id'         => 25,
                'name'       => 'Bar Utensils',
                'parent_id'  => 4,
                'created_at' => now(),
            ],
            [
                'id'         => 26,
                'name'       => 'Barware',
                'parent_id'  => 4,
                'created_at' => now(),
            ],
            [
                'id'         => 27,
                'name'       => 'Coffee Machine',
                'parent_id'  => 4,
                'created_at' => now(),
            ],
            [
                'id'         => 28,
                'name'       => 'F&B Carriers',
                'parent_id'  => 4,
                'created_at' => now(),
            ],
            [
                'id'         => 29,
                'name'       => 'Food Service Equipment',
                'parent_id'  => 4,
                'created_at' => now(),
            ],
            [
                'id'         => 30,
                'name'       => 'HK Equipment',
                'parent_id'  => 5,
                'created_at' => now(),
            ],
            [
                'id'         => 31,
                'name'       => 'HK Tools',
                'parent_id'  => 5,
                'created_at' => now(),
            ],
            [
                'id'         => 32,
                'name'       => 'Cold Room',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 33,
                'name'       => 'Cooking Equipment',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 34,
                'name'       => 'Dish Washing',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 35,
                'name'       => 'Food Preparation',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 36,
                'name'       => 'ICE MACHINES',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 37,
                'name'       => 'Oven',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 38,
                'name'       => 'Refrigeration',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 39,
                'name'       => 'Ventilation',
                'parent_id'  => 6,
                'created_at' => now(),
            ],
            [
                'id'         => 40,
                'name'       => 'Kitchen Tools',
                'parent_id'  => 7,
                'created_at' => now(),
            ],
            [
                'id'         => 41,
                'name'       => 'Knife',
                'parent_id'  => 7,
                'created_at' => now(),
            ],
            [
                'id'         => 42,
                'name'       => 'Pots & Pans',
                'parent_id'  => 7,
                'created_at' => now(),
            ],
            [
                'id'         => 43,
                'name'       => 'Storage & Carriers',
                'parent_id'  => 7,
                'created_at' => now(),
            ],
            [
                'id'         => 44,
                'name'       => 'Finishing Equipment',
                'parent_id'  => 8,
                'created_at' => now(),
            ],
            [
                'id'         => 45,
                'name'       => 'Flatwork Ironer',
                'parent_id'  => 8,
                'created_at' => now(),
            ],
            [
                'id'         => 46,
                'name'       => 'Tumble Dryer',
                'parent_id'  => 8,
                'created_at' => now(),
            ],
            [
                'id'         => 47,
                'name'       => 'Washer Extractor',
                'parent_id'  => 8,
                'created_at' => now(),
            ],
            [
                'id'         => 48,
                'name'       => 'Camwear',
                'parent_id'  => 9,
                'created_at' => now(),
            ],
            [
                'id'         => 49,
                'name'       => 'Ceramicware',
                'parent_id'  => 9,
                'created_at' => now(),
            ],
            [
                'id'         => 50,
                'name'       => 'Cutlery',
                'parent_id'  => 9,
                'created_at' => now(),
            ],
            [
                'id'         => 51,
                'name'       => 'Glassware',
                'parent_id'  => 9,
                'created_at' => now(),
            ],
            [
                'id'         => 52,
                'name'       => 'Serving Tools',
                'parent_id'  => 9,
                'created_at' => now(),
            ],
            [
                'id'         => 53,
                'name'       => 'Tray and Boxes',
                'parent_id'  => 9,
                'created_at' => now(),
            ],
        ];

        $childCategories = [
            [
                'id'         => 54,
                'name'       => 'Amenities',
                'parent_id'  => 14,
                'created_at' => now(),
            ],
            [
                'id'         => 55,
                'name'       => 'In-room Accessories',
                'parent_id'  => 14,
                'created_at' => now(),
            ],
            [
                'id'         => 56,
                'name'       => 'Gin',
                'parent_id'  => 23,
                'created_at' => now(),
            ],
            [
                'id'         => 57,
                'name'       => 'Liqueur',
                'parent_id'  => 23,
                'created_at' => now(),
            ],
            [
                'id'         => 58,
                'name'       => 'Tequila',
                'parent_id'  => 23,
                'created_at' => now(),
            ],
            [
                'id'         => 59,
                'name'       => 'Whisky',
                'parent_id'  => 23,
                'created_at' => now(),
            ],
            [
                'id'         => 60,
                'name'       => 'Wine',
                'parent_id'  => 23,
                'created_at' => now(),
            ],
            [
                'id'         => 61,
                'name'       => 'Wine Cooler',
                'parent_id'  => 24,
                'created_at' => now(),
            ],
            [
                'id'         => 62,
                'name'       => 'Coffee Accessories',
                'parent_id'  => 27,
                'created_at' => now(),
            ],
            [
                'id'         => 63,
                'name'       => 'Coffee Machine',
                'parent_id'  => 27,
                'created_at' => now(),
            ],
            [
                'id'         => 64,
                'name'       => 'Carriers',
                'parent_id'  => 43,
                'created_at' => now(),
            ],
            [
                'id'         => 65,
                'name'       => 'Storage',
                'parent_id'  => 43,
                'created_at' => now(),
            ],
        ];

        Category::insert($categories);
        Category::insert($subCategories);
        Category::insert($childCategories);
    }
}

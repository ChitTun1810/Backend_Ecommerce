<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                "name" => "dashboard_access",

            ],
            [
                "name" => "user_access",

            ],
            [
                "name" => "user_create",

            ],
            [
                "name" => "user_edit",

            ],
            [
                "name" => "user_delete",

            ],
            [
                "name" => "user_show",

            ],
            [
                "name" => "brand_access",

            ],
            [
                "name" => "brand_create",

            ],
            [
                "name" => "brand_edit",

            ],
            [
                "name" => "brand_delete",

            ],
            [
                "name" => "brand_show",

            ],
            [
                "name" => "product_access",

            ],
            [
                "name" => "product_create",

            ],
            [
                "name" => "product_edit",

            ],
            [
                "name" => "product_delete",

            ],
            [
                "name" => "product_show",

            ],
            [
                "name" => "category_access",

            ],
            [
                "name" => "category_create",

            ],
            [
                "name" => "category_edit",

            ],
            [
                "name" => "category_delete",

            ],
            [
                "name" => "category_show",

            ],
            [
                "name" => "banner_access",

            ],
            [
                "name" => "banner_create",

            ],
            [
                "name" => "banner_edit",

            ],
            [
                "name" => "banner_delete",

            ],
            [
                "name" => "banner_show",

            ],
            [
                "name" => "city_access",

            ],
            [
                "name" => "city_create",

            ],
            [
                "name" => "city_edit",

            ],
            [
                "name" => "city_delete",

            ],
            [
                "name" => "city_show",

            ],
            [
                "name" => "township_access",

            ],
            [
                "name" => "township_create",

            ],
            [
                "name" => "township_edit",

            ],
            [
                "name" => "township_delete",

            ],
            [
                "name" => "township_show",

            ],
            [
                "name" => "role_access",

            ],
            [
                "name" => "role_create",

            ],
            [
                "name" => "role_edit",

            ],
            [
                "name" => "role_delete",

            ],
            [
                "name" => "role_show",

            ],
            [
                "name" => "setting_access",
            ],
            [
                "name" => "customer_access",
            ],
            [
                "name" => "customer_create",
            ],
            [
                "name" => "customer_edit",
            ],
            [
                "name" => "customer_delete",
            ],
            [
                "name" => "customer_show",
            ],
            [
                "name" => "country_access",
            ],
            [
                "name" => "country_create",
            ],
            [
                "name" => "country_edit",
            ],
            [
                "name" => "country_delete",
            ],
            [
                "name" => "country_show",
            ],
            [
                "name" => "order_access",
            ],
            [
                "name" => "order_create",
            ],
            [
                "name" => "order_edit",
            ],
            [
                "name" => "order_delete",
            ],
            [
                "name" => "order_show",
            ],
            [
                "name" => "product_type_access",
            ],
            [
                "name" => "product_type_create",
            ],
            [
                "name" => "product_type_edit",
            ],
            [
                "name" => "product_type_delete",
            ],
            [
                "name" => "product_type_show",
            ],

            [
                "name" => "product_inquiry_access",
            ],
            [
                "name" => "product_inquiry_create",
            ],
            [
                "name" => "product_inquiry_edit",
            ],
            [
                "name" => "product_inquiry_delete",
            ],
            [
                "name" => "product_inquiry_show",
            ],
        ];

        $finals = [];
        foreach ($permissions as $key => $value) {
            $finals[] = [
                'name'       => $value['name'],
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Permission::insert($finals);
    }
}

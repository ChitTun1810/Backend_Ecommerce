<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\City;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Customer;
use App\Models\ProductUserManual;
use App\Models\Township;
use Illuminate\Database\Seeder;
use Database\Seeders\BannerSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        User::truncate();
        Brand::truncate();
        Customer::truncate();
        Product::truncate();

        $this->call([
            CategorySeeder::class,
            ProductImageSeeder::class,
            BannerSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            CountrySeeder::class,
            ProductTypeSeeder::class,
        ]);

        // User::factory(1)->create();
        Brand::factory(10)->create();
        Customer::factory(1)->create();
        Product::factory(20)->create();
        City::factory(1)->create();
        Township::factory(1)->create();
        Setting::factory(1)->create();
        ProductUserManual::factory(20)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}

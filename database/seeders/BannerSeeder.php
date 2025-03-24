<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'image' => 'https://lzd-img-global.slatic.net/us/domino/c49dd228dc7b6b8d1c8bef294649b50f.jpg_2200x2200q80.jpg'
            ],
            [
                'image' => 'https://lzd-img-global.slatic.net/us/domino/86ed9c5178f328b162da140a6ecfc8d4.jpg_2200x2200q80.jpg',
            ],
            [
                'image' => 'https://lzd-img-global.slatic.net/us/domino/0764518249bca99cf80efc0bd734baf0.jpg_2200x2200q80.jpg',
            ]
        ];

        Banner::insert($banners);
    }
}

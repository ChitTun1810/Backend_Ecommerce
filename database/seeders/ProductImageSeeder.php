<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [
                'product_id' => 1,
                'image' => 'https://lzd-img-global.slatic.net/g/p/db3120d0977b305ff57c8a59e1fae2d2.png_400x400q80.
                png'
            ],
            [
                'product_id' => 2,
                'image' => 'https://lzd-img-global.slatic.net/g/p/8f3f64c8b5c87a6268d4295615527cc0.jpg_400x400q80.j
                pg'
            ],
            [
                'product_id' => 3,
                'image' => 'https://lzd-img-global.slatic.net/g/p/fcfc9a2d8bfb9f9d362cf184d1147733.png_400x400q80.pn
                g_.webp'
            ],
            [
                'product_id' => 4,
                'image' => 'https://lzd-img-global.slatic.net/g/p/4655b328f931b613b8ceca4e684778bc.jpg_400x400q80.j
                pg_.webp'
            ],

            [
                'product_id' => 5,
                'image' => 'https://static-01.shop.com.mm/p/b0a8107340d3be36406c92c5f087e7f3.jpg'
            ],

            [
                'product_id' => 6,
                'image' => 'https://static-01.shop.com.mm/p/086ecc52ea5c62a3fd02dd1051d38136.jpg'
            ],

            [
                'product_id' => 7,
                'image' => 'https://mm-live-21.slatic.net/kf/S96a6b36a23ba4db693ef7677f79e15a9W.jpg'
            ],

            [
                'product_id' => 8,
                'image' => 'https://static-01.shop.com.mm/p/dfc30168ee00a0cd380403132dbfb7f4.jpg_400x400q75-pro
                duct.jpg_.webp'
            ],

            [
                'product_id' => 9,
                'image' => 'https://static-01.shop.com.mm/p/0f942cfcaf46fff893a7adb0904f28df.jpg_400x400q75-produc
                t.jpg_.webp'
            ],

            [
                'product_id' => 10,
                'image' => 'https://static-01.shop.com.mm/p/98295d958cc89d32acfbc44f3f091780.jpg_400x400q75-pro
                duct.jpg_.webp'
            ],

            [
                'product_id' => 11,
                'image' => 'https://static-01.shop.com.mm/p/b01d52cc7d0910d42fd03a85b79b8c44.jpg_400x400q75-pr
                oduct.jpg_.webp'
            ],

            [
                'product_id' => 12,
                'image' => 'https://static-01.shop.com.mm/p/9e6e10b5536097e52cc36f6e2511c6f3.jpg'
            ],

            [
                'product_id' => 13,
                'image' => 'https://static-01.shop.com.mm/p/c56f50a0d598d69f8b73d0b8a59b99ac.jpg'
            ],

            [
                'product_id' => 14,
                'image' => 'https://static-01.shop.com.mm/p/d15f49a3f6dd9458da941b6a20d8b25a.jpg'
            ],

            [
                'product_id' => 15,
                'image' => 'https://static-01.shop.com.mm/p/79723db315356c8f89bf613bda536bc3.jpg_300x0q75.webp'
            ],

            [
                'product_id' => 16,
                'image' => 'https://static-01.shop.com.mm/p/491ef2b4b56c30cf197d2b8c27522cd7.png_300x0q75.webp'
            ],

            [
                'product_id' => 17,
                'image' => 'https://static-01.shop.com.mm/p/2ae32c851d052031beb751ed3b673f42.jpg_300x0q75.web
                p'
            ],

            [
                'product_id' => 18,
                'image' => 'https://static-01.shop.com.mm/p/f1303216e56c94815c1d36dca753f75e.jpg_300x0q75.webp'
            ],

            [
                'product_id' => 19,
                'image' => 'https://static-01.shop.com.mm/p/7311af21c2f186a5b0f0c02a6e6c8d06.jpg_300x0q75.webp'
            ],

            [
                'product_id' => 20,
                'image' => 'https://static-01.shop.com.mm/p/3ea7824c3e9ed3717dc78633bd27c40e.jpg_300x0q75.web
                p'
            ],
        ];

        ProductImage::insert($images);
    }
}

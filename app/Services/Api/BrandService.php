<?php

namespace App\Services\Api;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandService
{
    protected $selectProductColumns = [
        'products.id',
        'products.name',
        'products.sku',
        'products.stocks',
        'products.brand_id',
        'products.category_id',
        'products.sub_category_id',
        'products.sub_child_id',
        'products.price',
        'products.description',
        'products.is_active'
    ];

    public function listing(Request $request)
    {
        $brand = Brand::select('id', 'name', 'image')
            ->orderBy('id', 'desc')
            ->paginate($request->limit);

        return $brand;
    }

    public function detail(Request $request, $id)
    {
        $products = Product::select($this->selectProductColumns)
            ->selectRaw('IFNULL(save_products.saved, 0) as fav')
            ->leftJoin('save_products', function ($s) {
                $s->on('save_products.product_id', '=', 'products.id');
                $s->where('save_products.customer_id', '=', Auth::id());
            })
            ->with(['images', 'brand:id,name,image'])
            ->where('brand_id', $id)
            ->active()
            ->orderBy('id', 'desc')
            ->paginate($request->limit);

        return $products;
    }
}

<?php

namespace App\Services\Api;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected $selectColumns = [
        'id',
        'name',
        'image',
        'parent_id'
    ];

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
        $category = Category::select($this->selectColumns)
            ->with([
                'children.children'
            ])
            ->whereNull('parent_id')
            ->orderBy('id', 'desc')
            ->paginate($request->limit);

        return $category;
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
            ->where('products.category_id', $id)
            ->orWhere('products.sub_category_id', $id)
            ->orWhere('products.sub_child_id', $id)
            ->active()
            ->orderBy('products.id', 'desc')
            ->paginate($request->limit);

        return $products;
    }
}

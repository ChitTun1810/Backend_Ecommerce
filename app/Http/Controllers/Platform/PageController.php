<?php

namespace App\Http\Controllers\Platform;

use App\Models\Brand;
use App\Models\Country;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductListingResource;
use App\Models\ProductType;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::orderBy('name', 'asc')
            ->get();

        $categories = Category::isParent()
            ->orderBy('name', 'asc')
            ->limit(6)
            ->get();

        $products = Product::with(['images', 'brand:id,name,image'])
            ->active()
            ->newArrival()
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $exchange_rate = Setting::select('exchange_rate')->first();

        return response()->json([
            'success'       => true,
            'exchange_rate' => $exchange_rate->exchange_rate,
            'data'          => [
                'categories' => $categories,
                'brands'     => $brands,
                'products'   => ProductListingResource::collection($products),
            ],
        ], 200);
    }

    public function productPage(Request $request)
    {
        $brands     = Brand::orderBy('name', 'asc')->get();
        $categories = Category::isParent()
            ->with('children.children')
            ->orderBy('name', 'asc')
            ->get();

        $productTypes = ProductType::orderBy('name', 'asc')->get();

        $countries = Country::orderBy('name', 'asc')->get();

        return response()->json([
            'success' => true,
            'data'    => [
                'brands'       => $brands,
                'categories'   => $categories,
                'countries'    => $countries,
                'productTypes' => $productTypes,
            ],
        ]);
    }
}

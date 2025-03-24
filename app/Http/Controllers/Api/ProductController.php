<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\ProductService;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Resources\Api\ProductListingResource;

class ProductController extends Controller
{
    public function listing(Request $request)
    {
        $request->validate([
            'page'    => 'required|numeric',
            'limit'   => 'required|numeric',
            'keyword' => 'nullable'
        ]);

        $productService = new ProductService();
        $result         = $productService->listing($request);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => ProductListingResource::collection($result->items()),
        ]);
    }

    public function newArrivalListing(Request $request)
    {
        $request->validate([
            'page'    => 'required|numeric',
            'limit'   => 'required|numeric',
        ]);

        $productService = new ProductService();
        $result = $productService->newArrival($request);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => ProductListingResource::collection($result->items()),
        ]);
    }

    public function detail($id)
    {
        $productService = new ProductService();
        $result         = $productService->detail($id);

        return response()->json([
            'success' => true,
            'data'    => $result,
        ]);
    }

    public function getFavouriteProducts(Request $request)
    {
        $request->validate([
            'page'    => 'required|numeric',
            'limit'   => 'required|numeric',
        ]);

        $productService = new ProductService();
        $result = $productService->favouriteProducts($request);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => ProductListingResource::collection($result->items()),
        ]);
    }

    public function saveProduct($id)
    {
        $productService = new ProductService();
        $productService->saveToggle($id);

        return response()->json([
            'success' => true,
            'message' => 'successfully saved',
        ]);
    }

    public function removeAllFavouriteProduct()
    {
        if (!auth()->user()->saveProducts->count()) {
            throw new Exception('Favourite product not found');
        }

        auth()->user()->saveProducts()->delete();
        return response()->json([
            'success' => true,
            'message' => 'successfully remove all favourite product'
        ]);
    }
}

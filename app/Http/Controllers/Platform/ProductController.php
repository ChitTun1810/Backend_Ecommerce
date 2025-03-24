<?php

namespace App\Http\Controllers\Platform;

use App\Http\Resources\Api\ProductListingResource;
use App\Http\Resources\ProductSearchResource;
use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\ProductService;

class ProductController extends Controller
{
    public function listing(Request $request)
    {
        $productService = new ProductService();
        $result         = $productService->listing($request);
        return response()->json([
            'success'   => true,
            'total'     => $result->total(),
            'has_pages' => $result->hasMorePages(),
            'data'      => ProductListingResource::collection($result->items()),
        ]);
    }

    public function detail($id)
    {
        $productService     = new ProductService();
        [$result, $related] = $productService->detail($id);

        return response()->json([
            'success'          => true,
            'data'             => $result,
            'related_products' => ProductListingResource::collection($related),
        ]);
    }

    public function getFavouriteProducts(Request $request)
    {
        $request->validate([
            'page'  => 'nullable|numeric',
            'limit' => 'required|numeric',
        ]);

        $productService = new ProductService();
        $result         = $productService->favouriteProducts($request);

        return response()->json([
            'success'   => true,
            'total'     => $result->total(),
            'has_pages' => $result->hasMorePages(),
            'data'      => ProductListingResource::collection($result->items()),
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
            'message' => 'successfully remove all favourite product',
        ]);
    }

    public function searchProduct(Request $request)
    {
        if (!$request->keyword) {
            return response()->json([
                'success' => false,
                'data'    => [],
            ]);
        }

        $productService = new ProductService();
        $result         = $productService->searchProduct($request);

        return response()->json([
            'success' => true,
            'data'    => ProductSearchResource::collection($result),
        ]);
    }

    public function sendProductInQuiry(Request $request)
    {
        $request->validate([

            'product_id' => 'required|numeric',
            'content'    => 'required',
            'name'       => 'required',
            'email'      => 'required|email',
            'phone'      => 'required',
        ]);

        $product = new ProductService();

        $product->sendInquiry($request);

        return response()->json([
            'success' => true,
            'message' => 'successful send',
        ]);
    }

}

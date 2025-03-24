<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    public function __construct(public ProductRepository $productRepository)
    {
    }

    public function index(Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric',
        ]);

        $result = $this->productRepository->listing($request);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => $result->getCollection(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string',
            'sku'             => 'nullable|string',
            'stocks'          => 'required|numeric',
            'brand_id'        => 'nullable|exists:brands,id',
            'category_id'     => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'sub_child_id'    => 'nullable|exists:categories,id',
            'price'           => 'required',
            'description'     => 'nullable',
            'is_active'       => 'nullable|boolean',
        ]);

        $result = $this->productRepository->store($request);

        return response()->json([
            'success' => true,
            'message' => 'successfully created',
            'data'    => $result,
        ]);
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'subCategory',
            'subChild'
        ])
            ->find($id);

        if (!$product) {
            throw new Exception('Product not found');
        }

        return response()->json([
            'success' => true,
            'data'    => $product,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required|string',
            'sku'             => 'nullable|string',
            'stocks'          => 'required|numeric',
            'brand_id'        => 'nullable|exists:brands,id',
            'category_id'     => 'nullable|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'sub_child_id'    => 'nullable|exists:categories,id',
            'price'           => 'required',
            'description'     => 'nullable',
            'is_active'       => 'nullable|boolean',
        ]);

        $product = Product::find($id);

        if (!$product) {
            throw new Exception('Product not found');
        }

        $result = $this->productRepository->update($request, $product);

        return response()->json([
            'success' => true,
            'message' => 'successfully update',
            'data'    => $result,
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new Exception('Product not found');
        }

        $this->productRepository->delete($product);

        return response()->json([
            'success' => true,
            'message' => 'successfully delete',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductListingResource;
use App\Services\Api\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function listing(Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        $categoryService = new CategoryService();
        $result          = $categoryService->listing($request);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => $result->getCollection(),
        ]);
    }

    public function detail($id, Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        $categoryService = new CategoryService();
        $result          = $categoryService->detail($request, $id);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => ProductListingResource::collection($result->getCollection()),
        ]);
    }
}

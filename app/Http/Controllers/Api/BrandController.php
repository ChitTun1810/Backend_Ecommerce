<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProductListingResource;
use App\Services\Api\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function listing(Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        $brandService = new BrandService();
        $result       = $brandService->listing($request);

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

        $brandService = new BrandService();
        $result       = $brandService->detail($request, $id);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => ProductListingResource::collection($result->getCollection()),
        ]);
    }
}

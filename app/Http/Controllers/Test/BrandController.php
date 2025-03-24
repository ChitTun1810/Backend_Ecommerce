<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use App\Repository\BrandRepository;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function __construct(public BrandRepository $brandRepository)
    {
    }

    public function index(Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric'
        ]);

        $result = $this->brandRepository->listing($request);

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
            'name'  => 'required|string',
            'image' => 'nullable|image',
        ]);

        $result = $this->brandRepository->store($request);

        return response()->json([
            'success' => true,
            'message' => 'successfully created',
            'data'    => $result,
        ]);
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            throw new Exception('Brand not found');
        }

        return response()->json([
            'success' => true,
            'data'    => $brand,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string',
            'image' => 'nullable|image',
        ]);

        $brand = Brand::find($id);
        if (!$brand) {
            throw new Exception('Brand not found');
        }

        $result = $this->brandRepository->update($request, $brand);

        return response()->json([
            'success' => true,
            'message' => 'successfully updated',
            'data'    => $result,
        ]);
    }

    public function delete($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            throw new Exception('Brand not found');
        }

        $this->brandRepository->delete($brand);

        return response()->json([
            'success' => true,
            'message' => 'successfully deleted',
        ]);
    }
}

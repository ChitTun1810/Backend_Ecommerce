<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\CategoryRepository;

class CategoryController extends Controller
{
    public function __construct(public CategoryRepository $categoryRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric',
        ]);

        $result = $this->categoryRepository->listing($request);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => $result->getCollection(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string',
            'image'     => 'nullable|image',
            'parent_id' => 'nullable|numeric|exists:App\Models\Category,id',
        ], [
            'parent_id.exists' => 'The parent not found'
        ]);

        $result = $this->categoryRepository->store($request);

        return response()->json([
            'success' => true,
            'message' => 'successfully created',
            'data'    => $result,
        ]);
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->first();
        if (!$category) {
            throw new Exception("Category not found");
        }

        return response()->json([
            'success' => true,
            'data'    => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string',
            'image'     => 'nullable|image',
            'parent_id' => 'nullable|numeric|exists:App\Models\Category,id',
        ], [
            'parent_id.exists' => 'The parent not found'
        ]);

        $category = Category::find($id);
        if (!$category) {
            throw new Exception("Category not found");
        }

        $result = $this->categoryRepository->update($request, $category);

        return response()->json([
            'success' => true,
            'message' => 'successfully update',
            'data'    => $result,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new Exception("Category not found");
        }

        $this->categoryRepository->delete($category);

        return response()->json([
            'success' => true,
            'message' => 'successfully delete',
        ]);
    }
}

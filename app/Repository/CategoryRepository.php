<?php

namespace App\Repository;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryRepository
{
    public function listing(?Request $request)
    {
        // $category = Category::with('children.children', 'products', 'children.products', 'children.children.products')
        //     ->whereNull('parent_id')
        //     ->orderBy('id', 'desc')
        //     ->paginate($request->limit ?? 10);

        $category = Category::with(['children.children', 'parent'])
            ->whereNull('parent_id')
            ->orderBy('id', 'desc')
            ->paginate($request->limit ?? 15);

        return $category;
    }

    public function store(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('categories');
        }

        $category = Category::create([
            'name'      => $request->name,
            'image'     => $image,
            'parent_id' => $request->parent_id,
        ]);

        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $image = $category?->image;
        if ($request->hasFile('image')) {
            if ($image) {
                Storage::delete($category->image);
            }
            $image = $request->file('image')->store('categories');
        }

        $category->update([
            'name'      => $request->name,
            'image'     => $image,
            'parent_id' => $request->parent_id ?? null,
        ]);

        return $category;
    }

    public function delete(Category $category)
    {
        $image = $category?->image;
        if ($image) {
            Storage::delete($category->image);
        }
        $category->delete();
    }

    public function getByParent($id)
    {
        $categories = Category::whereNotNull('parent_id')
            ->where('parent_id', $id)
            ->with(['children'])
            ->get();

        if (empty($categories)) {
             throw new Exception("Sub category is not found!");
        }

        return $categories;
    }
}

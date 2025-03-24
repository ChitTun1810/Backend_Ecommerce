<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProductTypeController extends Controller
{

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $productTypes = ProductType::with(['category'])
            ->orderBy('name', 'asc')
            ->paginate($request->limit ?? 10);

        return Inertia::render("Admin/ProductType/Index", [
            'productTypes' => $productTypes,
        ]);
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::orderBy('name', 'asc')->get();
        return Inertia::render("Admin/ProductType/Create", [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'category_id' => 'required',
        ]);
        ProductType::create([
            'name'        => $request->name,
            'category_id' => $request->category_id,
        ]);

        return to_route('admin.product-types.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $productType = ProductType::findOrFail($id);
        $categories  = Category::orderBy('name', 'asc')->get();

        return Inertia::render('Admin/ProductType/Edit', [
            'productType' => $productType,
            'categories'  => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required',
            'category_id' => 'required',
        ]);

        $productType = ProductType::findOrFail($id);

        $productType->update([
            'name'        => $request->name,
            'category_id' => $request->category_id,
        ]);

        return to_route('admin.product-types.index');
    }

    public function destroy($id)
    {
        $productType = ProductType::find($id);
        $productType->delete();
    }

    public function filterByCategory(Request $request)
    {
        $productTypes = ProductType::where('category_id', $request->id)->get();

        return response()->json([
            'data'    => $productTypes,
            'success' => true,
        ], 200);
    }
}

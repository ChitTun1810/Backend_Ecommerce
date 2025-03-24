<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Cart;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Country;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exports\ProductsExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\ProductUserManual;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Repository\ProductRepository;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ProductRepository $productRepository)
    {
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $products   = $this->productRepository->listing($request);
        $categories = Category::isParent()->get();
        $brands     = Brand::orderBy('name', 'asc')->get();
        return Inertia::render("Admin/Product/Index", [
            'products'   => $products,
            'categories' => $categories,
            'brands'     => $brands,
            'params'     => [
                'name'     => $request->name,
                'brand'    => $request->brand,
                'category' => $request->category,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $brands     = Brand::orderBy('name', 'asc')->get();
        $categories = Category::whereNull('parent_id')
            ->orderBy('name', 'asc')
            ->get();
        $countries  = Country::all();
        $productTypes = ProductType::orderBy('name', 'asc')->get();

        return Inertia::render("Admin/Product/Create", [
            'brands'        => $brands,
            'categories'    => $categories,
            'countries'     => $countries,
            'productTypes'  => $productTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'price'         => 'required|numeric',
            'stocks'        => 'nullable|numeric',
            // 'sku'         => 'required|unique:products,sku',
            'sku'           => ['required', Rule::unique('products')->whereNull('deleted_at')],
            'description'   => 'nullable|string',
            'brand_id'      => 'required|integer',
            'category_id'   => 'required|integer',
            'images'        => 'required|array|min:1|max:10',
            'images.*'      => 'required|image',
            'links'         => 'array',
            'links.*.title' => 'required_with:links.*.link',
            'links.*.link'  => 'required_with:links.*.title',
            'created_at'    => 'nullable',
        ], [
            'category_id.required'        => 'The category field is required.',
            'brand_id.required'           => 'The brand field is required.',
            'brand_id.integer'            => 'The brand must be integer.',
            'category_id.integer'         => 'The category must be integer.',
            'links.*.title.required_with' => "The link title field is required when link is present.",
            'links.*.link.required_with'  => "The link field is required when link title is present.",
        ]);

        $this->productRepository->store($request);

        return to_route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product = $this->_getDetail($id);
        return Inertia::render('Admin/Product/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product    = $this->_getDetail($id);
        $brands     = Brand::orderBy('name', 'asc')->get();
        $categories = Category::whereNull('parent_id')
            ->orderBy('name', 'asc')
            ->get();
        $countries  = Country::all();
        $productTypes = ProductType::orderBy('name', 'asc')->get();

        return Inertia::render('Admin/Product/Edit', [
            'product'       => $product,
            'brands'        => $brands,
            'categories'    => $categories,
            'countries'     => $countries,
            'productTypes'  => $productTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'price'         => 'required|numeric',
            'stocks'        => 'nullable|numeric',
            // 'sku'         => 'required|unique:products,sku,'.$id,
            'sku'           => ['required', Rule::unique('products')->whereNull('deleted_at')->ignore($id)],
            'description'   => 'nullable|string',
            'brand_id'      => 'required|integer',
            'category_id'   => 'required|integer',
            'images'        => 'nullable|array|max:10',
            'images.*'      => 'nullable|image',
            'old'           => 'nullable|array',
            'links'         => 'array',
            'links.*.title' => 'required_with:links.*.link',
            'links.*.link'  => 'required_with:links.*.title',
        ], [
            'category_id.required'        => 'The category field is required.',
            'brand_id.required'           => 'The brand field is required.',
            'brand_id.integer'            => 'The brand must be integer.',
            'category_id.integer'         => 'The category must be integer.',
            'links.*.title.required_with' => "The link title field is required when link is present.",
            'links.*.link.required_with'  => "The link field is required when link title is present.",
        ]);

        $product = Product::findOrFail($id);
        $this->productRepository->update($request, $product);
        if ($request->input('is_redirect')) {
            return to_route('admin.products.index');
        }
        else {
            return back()->with([
                'product' => $product,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $this->productRepository->delete($product);
    }

    private function _getDetail($id): Product
    {
        $product = Product::with([
            'category',
            'subCategory',
            'subChild',
            'brand',
            'images',
            'country',
            'userManualLinks',
            'productType',
        ])->findOrFail($id);

        return $product;
    }

    public function newArrival($id)
    {
        $product = Product::findOrFail($id);
        $this->productRepository->newArrival($product);
    }

    public function browse()
    {
        return Inertia::render('Admin/Product/Import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $this->productRepository->importExcel($request);

        return to_route('admin.products.index');
    }

    public function deleteAll(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $products = Product::whereIn('id', request('ids'));
            $products->delete();

            $carts = Cart::whereIn('product_id', request('ids'));
            $carts->delete();
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
        return to_route('admin.products.index');
    }

    public function deleteLink($id)
    {
        ProductUserManual::findOrFail($id)->delete();
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}

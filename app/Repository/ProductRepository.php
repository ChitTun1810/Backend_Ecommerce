<?php

namespace App\Repository;

use App\Imports\ProductsImport;
use Exception;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductUserManual;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductRepository
{
    public $productImageArray = [];

    public function listing(Request $request)
    {
        $query = Product::with([
            'category',
            'subCategory',
            'subChild',
            'brand',
            'country',
            'productType',
        ]);

        if ($request->name) {
            $query = $query->where("name", "LIKE", "%{$request->name}%")
                ->orWhere("sku", "LIKE", "%{$request->name}%");
        }

        if ($request->brand) {
            $query = $query->where('brand_id', $request->brand);
        }

        if ($request->category) {
            $query = $query->where('category_id', $request->category);
        }

        if ($request->sub_category) {
            $query = $query->where('sub_category_id', $request->sub_category);
        }

        if ($request->sub_child) {
            $query = $query->where('sub_child_id', $request->sub_child);
        }

        if ($request->stock) {
            $query = $query->where('stocks', '<=', $request->stock);
        }

        $product = $query
            ->orderBy('products.created_at', 'desc')
            ->paginate($request->limit ?? 10)
            ->withQueryString();

        return $product;
    }

    public function store(Request $request)
    {

        $timestamp = null;
        if ($request->created_at) {
            $timestamp = Carbon::parse($request->created_at)->timestamp;
        }

        $product = Product::create([
            'name'             => $request->name,
            'sku'              => $request->sku ?? null,
            'stocks'           => $request->stocks,
            'brand_id'         => $request->brand_id ?? null,
            'category_id'      => $request->category_id ?? null,
            'sub_category_id'  => $request->sub_category_id ?? null,
            'sub_child_id'     => $request->sub_child_id ?? null,
            'country_id'       => $request->country_id ?? null,
            'product_type_id'  => $request->product_type_id,
            'price'            => $request->price,
            'description'      => $request->description,
            'key_information'  => $request->key_information,
            'specification'    => $request->specification,
            'is_active'        => !empty($request->is_active) ? 1 : 0,
            'is_specification' => !empty($request->is_specification) ? 1 : 0,
            'created_at'       => $timestamp ?? now()
        ]);

        if (!empty($request->images) && count($request->images) > 0) {
            if ($request->file('images')) {
                $this->_createProductImages($product->id, $request->file('images'));
            }
        }

        $links = [];

        foreach ($request->links as $key => $value) {
            if (!empty($value['title']) && !empty($value['link'])) {
                $links[] = [
                    'title' => $value['title'],
                    'link'  => $value['link'],
                ];
            }
        }

        if (!empty($request->links)) {
            $product->userManualLinks()->createMany($links);
        }

        return $product;
    }

    public function update(Request $request, Product $product)
    {
        $timestamp = null;
        if ($request->created_at) {
            $timestamp = Carbon::parse($request->created_at)->timestamp;
        }

        $product->update([
            'name'             => $request->name,
            'sku'              => $request->sku ?? null,
            'stocks'           => $request->stocks,
            'brand_id'         => $request->brand_id ?? null,
            'category_id'      => $request->category_id ?? null,
            'sub_category_id'  => $request->sub_category_id ?? null,
            'sub_child_id'     => $request->sub_child_id ?? null,
            'product_type_id'  => $request->product_type_id,
            'country_id'       => $request->country_id ?? null,
            'price'            => $request->price,
            'description'      => $request->description,
            'key_information'  => $request->key_information,
            'specification'    => $request->specification,
            'is_active'        => !empty($request->is_active) ? 1 : 0,
            'is_specification' => !empty($request->is_specification) ? 1 : 0,
            'created_at'       => $timestamp ?? now(),
        ]);

        if (!empty($request->old)) {
            if ($product->images->count() <= 1 && empty($request->images)) {
                return redirect()->back()->withErrors([
                    'images' => 'Image not delete',
                ]);
            }

            $files = $product->images()
                ->whereIn('id', $request->old)
                ->get();

            if (count($files) > 0) {
                foreach ($files as $file) {
                    $oldImage = $file->getRawOriginal('image') ?? '';
                    Storage::delete($oldImage);
                }

                $product->images()->whereIn('id', $request->old)->delete();
            }
        }

        if (!empty($request->images) && count($request->images) > 0) {
            if ($request->file('images')) {
                $this->_createProductImages($product->id, $request->file('images'));
            }
        }

        // Create Product Link
        if (!empty($request->links)) {
            foreach ($request->links as $link) {
                if (!empty($link['link']) && !empty($link['title'])) {

                    if (!isset($link['id'])) {
                        $product->userManualLinks()->create([
                            'link'  => $link['link'],
                            'title' => $link['title'],
                        ]);
                    }
                    else {
                        ProductUserManual::where('id', $link['id'])
                            ->update([
                                'link'  => $link['link'],
                                'title' => $link['title'],
                            ]);
                    }
                }
            }
        }

        return $product;
    }

    public function delete(Product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete();
            $product->carts()->delete();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function _createProductImages($productId, $files)
    {
        foreach ($files as $image) {
            $this->productImageArray[] = [
                'product_id' => $productId,
                'image'      => $image->store('products'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ProductImage::insert($this->productImageArray);
    }

    public function newArrival(Product $product)
    {
        $product->update([
            'is_new_arrival' => !$product->is_new_arrival,
        ]);
    }

    public function importExcel(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file'));
    }
}

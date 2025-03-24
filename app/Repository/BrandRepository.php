<?php

namespace App\Repository;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandRepository
{
    public function listing(Request $request)
    {
        $brand = Brand::orderBy('name', 'asc')
            ->paginate($request->limit ?? 10);

        return $brand;
    }

    public function store(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('brands');
        }

        $brand = Brand::create([
            'name'  => $request->name,
            'image' => $image,
        ]);

        return $brand;
    }

    public function update(Request $request, Brand $brand)
    {
        $image = $brand?->image;
        if ($request->hasFile('image')) {
            if ($image) {
                Storage::delete($brand->image);
            }
            $image = $request->file('image')->store('brands');
        }

        $brand->update([
            'name'  => $request->name,
            'image' => $image,
        ]);

        return $brand;
    }

    public function delete(Brand $brand)
    {
        $image = $brand?->image;
        if ($image) {
            Storage::delete($brand->image);
        }
        $brand->delete();
    }
}

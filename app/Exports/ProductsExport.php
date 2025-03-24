<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view("exports.product", [
            "products" => Product::latest("id")->with([
                'brand:id,name',
                'category:id,name',
                'subCategory:id,name',
                'subChild:id,name',
                'productType:id,name',
            ])->get(),
        ]);
    }
}

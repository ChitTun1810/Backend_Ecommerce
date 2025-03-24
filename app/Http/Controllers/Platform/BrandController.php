<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function listing(Request $request)
    {
        $query = Brand::orderBy('name', 'asc');

        if ($request->limit) {
            $query = $query->limit($request->limit);
        }

        $brands = $query->get();

        return response()->json([
            'data'    => $brands,
            'success' => true,
        ]);
    }
}

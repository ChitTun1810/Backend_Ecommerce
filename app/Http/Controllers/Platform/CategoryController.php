<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function listing(Request $request)
    {
        $request->validate([
            'limit' => 'nullable',
        ]);

        $query = Category::with(['children.children'])
            ->isParent()
            ->orderBy("name", "asc");

        $currency = Setting::active()->first();

        if (isset ($request->limit)) {
            $query = $query->limit($request->limit);
        }

        $categories = $query->get();

        return response()->json([
            'success'  => true,
            'data'     => $categories,
            // 'currency' => $currency?->exchange_rate ?? 0,
            'currency' => 3600,
        ]);
    }
}

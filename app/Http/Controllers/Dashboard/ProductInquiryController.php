<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductInquiry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class ProductInquiryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = ProductInquiry::with(['product', 'customer'])
            ->latest('id')
            ->paginate($request->limit ?? 10);
        return Inertia::render('Admin/ProductInquiry/Index', [
            'products' => $products,
        ]);
    }


    public function show($id)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $product = ProductInquiry::with(['product', 'customer'])->find($id);
        return Inertia::render('Admin/ProductInquiry/Show', [
            'product' => $product,
        ]);
    }

    public function destroy($id)
    {
        $product = ProductInquiry::findOrFail($id);
        $product->delete();
    }
}

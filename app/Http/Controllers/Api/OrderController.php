<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function listing(Request $request)
    {
        $request->validate([
            'page'  => 'required|numeric',
            'limit' => 'required|numeric',
        ]);

        $result = Order::with(['orderCustomer'])
            ->orderBy('id', 'desc')
            ->where(function ($query) {
                $query->where('payment_status', Order::PAYMENT_STATUS['paid'])
                      ->orWhere('is_cod', 1);
            })
            ->where('customer_id', Auth::user()->id)
            ->paginate($request->limit);

        return response()->json([
            'success'       => true,
            'can_load_more' => canLoadMore($result),
            'total'         => $result->total(),
            'data'          => $result->items(),
        ]);
    }

    public function detail($id)
    {
        $order = Order::with([
            'orderProducts',
            'orderProducts.product',
            'orderProducts.product.images',
            'orderCustomer',
            'orderCustomer.customer',
        ])
            ->where('id', $id)
            ->where('customer_id', Auth::user()->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $order,
        ]);
    }
}

<?php

namespace App\Services\Api;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function listing()
    {
        $carts = Cart::orderBy('id', 'desc')
            ->authUser()
            ->limit(25)
            ->get();

        return $carts;
    }

    public function store(Request $request)
    {
        $product = Product::where('id', $request->product_id)
            ->active()
            ->firstOrFail();

        if (auth()->user()->carts->count() >= 25) {
            throw new Exception('Cart count limit is full, you can checkout first in your carts');
        }

        if ($request->quantity > $product->stocks) {
            throw new Exception('Insufficient product stocks');
        }

        Cart::updateOrCreate(
            [
                'customer_id' => Auth::id(),
                'product_id'  => $request->product_id,
            ],
            [
                'quantity' => DB::raw('quantity + ' . $request->quantity),
            ]
        );
    }

    public function update(Request $request, Cart $cart)
    {
        $product = Product::where('id', $request->product_id)
            ->active()
            ->firstOrFail();

        if ($request->quantity > $product->stocks) {
            throw new Exception('Insufficient product stocks');
        }

        $cart = $cart->update([
            'customer_id' => Auth::id(),
            'product_id'  => $request->product_id,
            'quantity'    => $request->quantity,
        ]);

        return $cart;
    }

    public function delete(Cart $cart)
    {
        $cart->delete();
    }

    public function deleteAll()
    {
        auth()->user()->carts()->delete();
    }
}

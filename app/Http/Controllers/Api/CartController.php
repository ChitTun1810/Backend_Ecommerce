<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use App\Services\Api\CartService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(public CartService $cartService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = $this->cartService->listing();

        return response()->json([
            'success' => true,
            'data'    => $carts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer'
        ]);

        $cart = $this->cartService->store($request);

        return response()->json([
            'success' => true,
            'message' => 'successfully create',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'required|integer'
        ]);

        $cart = Cart::authUser()->find($id);
        if(!$cart) {
            throw new Exception('Cart Not Found');
        }

        $cart = $this->cartService->update($request, $cart);

        return response()->json([
            'success' => true,
            'message' => 'successfully update',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::authUser()->find($id);
        if(!$cart) {
            throw new Exception('Cart Not Found');
        }

        $this->cartService->delete($cart);

        return response()->json([
            'success' => true,
            'message' => 'successfully delete',
        ]);
    }

    public function allClear()
    {
        $this->cartService->deleteAll();

        return response()->json([
            'success' => true,
            'message' => 'successfully delete all'
        ]);
    }

    public function cartCount()
    {
        return response()->json([
            'success' => true,
            'count' => auth()->user()->carts->sum('quantity') ?? 0,
        ]);
    }
}

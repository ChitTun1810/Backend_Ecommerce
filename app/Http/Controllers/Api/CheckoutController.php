<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\CheckoutService;
use App\Services\Api\CheckPaymentService;
use App\Http\Resources\CheckoutListingResource;

class CheckoutController extends Controller
{
    public function getCheckout(Request $request)
    {
        $request->validate([
            'city_id'     => 'nullable',
            'township_id' => 'nullable',
        ]);

        $checkoutService                              = new CheckoutService();
        [$carts, $totalPrice, $deliveryFee, $setting] = $checkoutService->checkoutList($request, 'listing');
        $USDPrice                                     = $totalPrice;
        $MMKPrice                                     = $totalPrice * $setting->exchange_rate;
        $total                                        = $MMKPrice + $deliveryFee;
        $grandTotal                                   = $total + calculateTaxAndDiscount('percent', $setting->tax, $MMKPrice);

        return response()->json([
            'success' => true,
            'total'   => auth()->user()->carts->count(),
            'list'    => [
                'products' => CheckoutListingResource::collection($carts),
            ],
            'prices'  => [
                'usd_sub_total'       => $USDPrice,
                'sub_total'           => $MMKPrice,
                'delivery_fee'        => $deliveryFee,
                'tax'                 => $setting->tax,
                'delivery_fee_status' => $setting->delivery_fee_status,
                'grand_total'         => $grandTotal,
                'exchange_rate'       => $setting->exchange_rate,
            ],
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'city_id'        => 'required',
            'township_id'    => 'required',
            'phone'          => 'nullable',
            'address_detail' => 'nullable',
            'is_cod'         => 'required|boolean',
        ]);

        $checkoutService = new CheckoutService();
        return $checkoutService->checkoutCreate($request);
    }

    public function callback(Request $request)
    {
        $payload        = $request->paymentResponse;
        $decode         = json_decode(base64_decode($payload));
        $invoiceNumber  = $decode->invoiceNo;
        $paymentService = new CheckPaymentService($invoiceNumber, true);
        return $paymentService->checkPayment();
    }

    public function webhook(Request $request)
    {
        $payload       = $request->payload;
        $decode        = json_decode(base64_decode($payload));
        $invoiceNumber = $decode->invoiceNo;
        $repository    = new CheckPaymentService($invoiceNumber, false);
        return $repository->checkPayment();
    }
}

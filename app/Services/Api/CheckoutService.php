<?php

namespace App\Services\Api;

use Exception;
use App\Models\Cart;
use App\Classes\CCPP;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Township;
use App\Models\PaymentLog;
use App\Models\PaymentLogs;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Models\OrderCustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{
    public $isRedirect = false;

    public $totalPrice = 0;

    protected $cartItems;

    protected $subTotal = 0;

    protected $deliveryFee = 0;

    protected array $orderItemsArray = [];

    protected array $productPrices = [];

    protected ?Township $township;

    public Request $request;

    public Setting $setting;

    public function checkoutList(Request $request, $status = null)
    {
        $carts = Cart::with('product', 'product.images')
            ->authUser()
            ->orderBy('id', 'desc')
            ->get();

        $this->township = Township::where('city_id', $request->city_id)
            ->where('id', $request->township_id)
            ->first();

        if (!$carts || $carts->count() <= 0) {
            throw new Exception('No items in the carts');
        }

        $this->setting = Setting::active()->first();

        $products = Product::select('id', 'stocks')
            ->active()
            ->whereIn('id', $carts->pluck('product_id'))
            ->pluck('stocks', 'id');

        foreach ($carts as $cart) {
            if (!isset($products[$cart->product_id]) || $products[$cart->product_id] < $cart->quantity) {
                if (isset($status)) {
                    continue;
                }
                throw new Exception('Product ' . $cart->product->name . ' not found in stocks.');
            } else {
                $this->productPrices[$cart->product->id] = $cart->product->price;
                $this->totalPrice += $cart->product->price * $cart->quantity;
            }
        }

        return [$carts, $this->totalPrice, $this->township?->delivery_fee ?? 0, $this->setting];
    }

    public function checkoutCreate(Request $request)
    {
        $this->request                                                          = $request;
        [$this->cartItems, $this->subTotal, $this->deliveryFee, $this->setting] = $this->checkoutList($request);

        DB::beginTransaction();
        try {
            $order = $this->_createOrder();
            $this->_createOrderProducts($order);
            $this->_createOrderCustomer($order);
            $redirect = $this->_getReturn($order);
            DB::commit();

            if (!$this->request->is_cod) {
                return response()->json([
                    'success'      => true,
                    'message'      => 'success',
                    'redirect'     => $this->isRedirect,
                    'redirect_url' => $redirect->webPaymentUrl,
                ]);
            }

            return response()->json([
                'success'  => true,
                'message'  => 'success',
                'redirect' => $this->isRedirect,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    private function _createOrder()
    {
        $changeSubTotal = $this->subTotal * $this->setting->exchange_rate;
        // $grandTotal     = $changeSubTotal + $this->deliveryFee + calculateTaxAndDiscount('percent', $this->setting->tax, $changeSubTotal);
        $grandTotal = $changeSubTotal + $this->deliveryFee + calculateTaxAndDiscount('percent', $this->setting->tax, $changeSubTotal);
        // $grandTotal     = $changeSubTotal; // remove line

        $order = Order::create([
            'order_number'    => generateCode(Order::class),
            'customer_id'     => Auth::id(),
            'delivery_fee'    => $this->deliveryFee,
            'exchange_rate'   => $this->setting->exchange_rate,
            'usd_total'       => $this->subTotal,
            'total'           => $changeSubTotal,
            'tax'             => $this->setting->tax,
            'grand_total'     => $grandTotal,
            'delivery_status' => Order::DELIVERY_STATUS['pending'],
            'payment_status'  => Order::PAYMENT_STATUS['unpaid'],
        ]);

        return $order;
    }

    private function _createOrderProducts(Order $order)
    {
        foreach ($this->cartItems as $item) {
            $subTotal = $this->productPrices[$item['product_id']] * 100; // sub total of product

            $this->orderItemsArray[] = [
                'order_id'    => $order->id,
                'product_id'  => $item['product_id'],
                'quantity'    => $item['quantity'],
                'price'       => $subTotal,
                'total_price' => $subTotal * $item['quantity'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ];

            if($this->request->is_cod) {
                Product::find($item['product_id'])->decrement('stocks', $item['quantity']);
            }
        }

        OrderProduct::insert($this->orderItemsArray);
    }

    private function _createOrderCustomer(Order $order)
    {
        $orderCustomer = OrderCustomer::create([
            'order_id'       => $order->id,
            'customer_id'    => Auth::id(),
            'phone'          => $this->request->phone ?? auth()->user()?->phone,
            'city_name'      => $this->township->city?->name,
            'township_name'  => $this->township->name,
            'address_detail' => $this->request->address_detail,
        ]);

        return $orderCustomer;
    }

    public function _getReturn(Order $order)
    {
        if (!$this->request->is_cod) {
            $this->isRedirect = true;
            // $refNumber = Str::uuid();
            $refNumber = $order->order_number;
            $redirect  = (new CCPP($order))->getPaymentToken($refNumber);
            // $redirect  = (new CCPP($order))->getPaymentToken($order->order_number);

            PaymentLog::create([
                'order_id'      => $order->id,
                'order_number'  => $refNumber,
                'payment_token' => $redirect->paymentToken,
                'status'        => 'new',
                'currency_code' => $this->request->currency_code ?? config('constants.currency.MMK'),
            ]);

            $order->reference_number = $refNumber;
            $order->update();

            return $redirect;
        }

        // if cod 
        // order update if cash on delivery 
        // check again reduce stock and other changes
        $order->is_cod = true;
        $order->update();

        $order->orderCustomer->customer->carts()->delete();

        return;
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\Api\OrderListingResource;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $query = Order::orderBy('id', 'desc');

        if ($request->order_no) {
            $query = $query->where("order_number", "LIKE", "%{$request->order_no}%");
        }

        if ($request->delivery) {
            $query = $query->where("delivery_status", "$request->delivery");
        }

        if ($request->payment) {
            $query = $query->where("payment_status", "$request->payment");
        }

        $orders = $query->paginate(10)->withQueryString();

        $deliveryStatus = Order::DELIVERY_STATUS;
        $paymentStatus  = Order::PAYMENT_STATUS;
        $params         = $request->all();

        return Inertia::render("Admin/Order/Index", [
            'orders'         => $orders,
            'deliveryStatus' => $deliveryStatus,
            'paymentStatus'  => $paymentStatus,
            'params'         => $params,
        ]);
    }

    public function update($id, Request $request)
    {
        $order                  = Order::findOrFail($id);
        $order->delivery_status = $request->status;
        $order->payment_status  = $request->payment_status;
        $order->update();
        return back();
    }

    public function show($id)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order = Order::with([
            'orderProducts',
            'orderProducts.product',
            'orderProducts.product.images',
            'orderCustomer',
            'orderCustomer.customer',
            'paymentLog',
        ])
            ->where('id', $id)
            ->firstOrFail();

        $deliveryStatus = Order::DELIVERY_STATUS;

        return Inertia::render("Admin/Order/Show", [
            'order'          => $order,
            'deliveryStatus' => $deliveryStatus,
        ]);
    }

    public function refund($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($id);

            $order->delivery_status = Order::REFUND_STATUS;
            $order->update();

            foreach ($order->orderProducts as $orderProduct) {
                Product::find($orderProduct->product_id)->increment('stocks', $orderProduct->quantity);
            }

            DB::commit();
            return back();
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

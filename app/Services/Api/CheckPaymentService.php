<?php

namespace App\Services\Api;

use Exception;
use Carbon\Carbon;
use App\Classes\CCPP;
use App\Classes\FirebaseNotification;
use App\Models\Order;
use App\Models\Product;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\DB;

class CheckPaymentService
{
    public $log;

    /**
     * class constructor
     */
    public function __construct(protected $invoiceNumber, protected $redirect = true)
    {
    }

    public function checkPayment()
    {
        try {
            $this->log = PaymentLog::where('order_number', $this->invoiceNumber)
                ->first();

            if (!$this->log) {
                return $this->response('fail', 'Booking not found');
            }

            if ($this->log->status == 'success') {
                return $this->response('success', 'Success');
            }

            $ccpp         = new CCPP($this->log, $this->log->currency_code);
            $paymentToken = $this->log->payment_token;
            $result       = $ccpp->paymentInquiry($paymentToken, $this->invoiceNumber);

            if ($result->respCode && $result->respCode !== '0000') {
                return $this->response('fail', 'Payment Error');
            }

            DB::beginTransaction();
            try {
                $this->log->payment_channel = ccpp_payments()[$result->channelCode] ?? $result->channelCode;
                $this->log->update();

                $order = Order::where('reference_number', $this->invoiceNumber)->first();

                if (!$order) {
                    return $this->response('fail', 'Order not found');
                }

                $order->payment_status = Order::PAYMENT_STATUS['paid'];
                $order->update();

                foreach ($order->orderProducts as $orderProduct) {
                    Product::find($orderProduct->product_id)->decrement('stocks', $orderProduct->quantity);
                }

                $order->orderCustomer->customer->carts()->delete();

                DB::commit();
                $notify = new FirebaseNotification();
                $route  = route('admin.orders.show', $order->id);
                $notify->handle('Order confirm', "$order->order_number was confirmed.", $route);
            }
            catch (Exception $e) {
                DB::rollBack();
                return $this->response('fail', $e->getMessage());
            }

            return $this->response('success', 'Success');
        }
        catch (Exception $e) {
            return $this->response('fail', $e->getMessage());
        }
    }

    public function response($status, $message)
    {
        $success = $status == 'success' ? true : false;

        if ($this->log) {
            $this->log->status = $status;
            $this->log->save();
        }

        return (!$this->redirect)
            ? ['success' => $success, 'message' => $message] :
            ($this->log->status !== 'success'
                ? redirect(config('ccpp.PAYMENT_FINAL_URL') . '/checkout')
                : redirect(config('ccpp.finalUrl')));
    }
}

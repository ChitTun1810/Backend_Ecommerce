<?php

namespace App\Models;

use Carbon\Carbon;
use App\Casts\Currency;
use App\Models\OrderCustomer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    const PAYMENT_STATUS = [
        'paid'   => 'paid',
        'unpaid' => 'unpaid',
    ];

    const DELIVERY_STATUS = [
        'pending'    => 'pending',
        'confirmed'  => 'confirmed',
        'delivering' => 'delivering',
        'delivered'  => 'delivered',
        // 'cancel'     => 'cancel',
    ];

    const REFUND_STATUS = 'refund';

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'order_number',
        'delivery_fee',
        'exchange_rate',
        'tax',
        'usd_total',
        'total',
        'grand_total',
        'reference_number',
        'delivery_status',
        'payment_status',
        'paid_at',
        'is_cod'
    ];

    protected $casts = [
        'delivery_fee' => Currency::class,
        'total'        => Currency::class,
        'grand_total'  => Currency::class,
        'paid_at'      => 'date',
        'is_cod'       => 'boolean',
    ];

    public function getCreatedFormatAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d h:i:s');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function orderCustomer()
    {
        return $this->hasOne(OrderCustomer::class, 'order_id', 'id');
    }

    public function scopeIsParent(Builder $query)
    {
        return $query->where('parent_id', null);
    }

    public function scopeToday(Builder $query)
    {
        return $query->whereDate('created_at', now()->today());
    }

    public function paymentLog()
    {
        return $this->hasOne(PaymentLog::class);
    }
}

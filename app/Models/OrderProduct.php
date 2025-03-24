<?php

namespace App\Models;

use App\Casts\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total_price'
    ];

    protected $casts = [
        'price'       => Currency::class,
        'total_price' => Currency::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}

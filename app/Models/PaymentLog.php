<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table = 'payment_logs';

    protected $fillable = [
        'order_id',
        'order_number',
        'payment_channel',
        'payment_token',
        'status',
        'currency_code'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCustomer extends Model
{
    use HasFactory;

    protected $table = 'order_customers';

    protected $fillable = [
        'order_id', 
        'customer_id',
        'phone',
        'city_name',
        'township_name',
        'address_detail',
        'note',
    ];

    public function customer()
    {
       return $this->belongsTo(Customer::class);
    }
}

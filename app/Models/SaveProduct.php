<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveProduct extends Model
{
    use HasFactory;

    protected $table = 'save_products';

    protected $fillable = [
        'product_id',
        'customer_id',
        'saved',
    ];
}

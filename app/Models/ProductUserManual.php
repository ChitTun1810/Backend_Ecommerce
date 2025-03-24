<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUserManual extends Model
{
    use HasFactory;

    public $table = "product_user_manuals";

    protected $fillable = ['product_id', 'link', 'title'];
}

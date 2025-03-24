<?php

namespace App\Models;

use App\Casts\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'sku',
        'stocks',
        'brand_id',
        'category_id',
        'sub_category_id',
        'sub_child_id',
        'product_type_id',
        'country_id',
        'price',
        'description',
        'key_information',
        'is_active',
        'is_new_arrival',
        'specification',
        'is_specification',
        'created_at',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'is_specification' => 'boolean',
        'is_new_arrival'   => 'boolean',
        'price'            => Currency::class,
    ];

    public $appends = ['except_title'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id', 'id');
    }

    public function subChild()
    {
        return $this->belongsTo(Category::class, 'sub_child_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function scopeNewArrival(Builder $query): void
    {
        $query->where('is_new_arrival', 1);
    }

    public function getexceptTitleAttribute()
    {
        return Str::limit($this->name, 28);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function userManualLinks()
    {
        return $this->hasMany(ProductUserManual::class, 'product_id', 'id');
    }

    public function productInquiries()
    {
        return $this->hasMany(ProductInquiry::class, 'product_id', 'id');
    }
}

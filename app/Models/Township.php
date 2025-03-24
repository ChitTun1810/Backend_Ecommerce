<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Township extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['city_id', 'name', 'delivery_fee'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

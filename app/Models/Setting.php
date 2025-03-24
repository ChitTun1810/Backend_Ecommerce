<?php

namespace App\Models;

use App\Casts\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'exchange_rate',
        'tax',
        'delivery_fee_status',
    ];

    protected $casts = [
        'exchange_rate' => Currency::class,
        'tax'           => Currency::class,
    ];

    public function scopeActive(Builder $query): void
    {
        $query->where('id', config('constants.setting_id'));
    }
}

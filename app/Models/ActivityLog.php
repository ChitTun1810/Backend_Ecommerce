<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['log_name', 'description', 'causer_id'];

    public $appends = ['date_format'];

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    public function getDateFormatAttribute()
    {
        return $this->created_at->format('d/m/Y - h:iA');
    }
}

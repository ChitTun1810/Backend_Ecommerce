<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'subject', 'message'];

    public $appends = ['except_subject', 'except_message', 'format_date'];


    public function getexceptSubjectAttribute()
    {
        return Str::limit($this->subject, 20);
    }

    public function getexceptMessageAttribute()
    {
        return Str::limit($this->message, 20);
    }

    public function getFormatDateAttribute()
    {
        return $this->created_at->format('d-M-Y');
    }
}

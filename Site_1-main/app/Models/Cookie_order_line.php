<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cookie_order_line extends Model
{
    use HasFactory;

    // relatie tussen de models
    public function cookie()
    {
        return $this->belongsTo(Cookie::class)->withDefault();   // een cookie_order_line heeft één 'cookie'
    }

    public function cookie_order()
    {
        return $this->belongsTo(Cookie_order::class)->withDefault();   // een cookie_order_line heeft één 'cookie_order'
    }

    // guarded property
    protected $guarded = ['id'];



}

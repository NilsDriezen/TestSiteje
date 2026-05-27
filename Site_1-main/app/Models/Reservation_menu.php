<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation_menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'menu_id',
        'quantity',
    ];

    // relatie tussen de models
    public function reservation()
    {
        return $this->belongsTo(Reservation::class)->withDefault();   // een reservation_menu heeft één 'reservation'
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class)->withDefault();   // een reservation_menu heeft één 'menu'
    }
}

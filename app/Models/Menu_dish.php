<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_dish extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'dish_id', 'course_id'];
//    public $timestamps = false;

    // relatie tussen de models
    public function menu()
    {
        return $this->belongsTo(Menu::class)->withDefault();   // een menu_dish heeft één 'menu'
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class)->withDefault();   // een menu_dish heeft één 'dish'
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish_ingredient extends Model
{
    use HasFactory;

    public $timestamps = false;
    // relatie tussen de models
    public function dish()
    {
        return $this->belongsTo(Dish::class)->withDefault();   // een dish_ingredient heeft één 'dish'
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class)->withDefault();   // een dish_ingredient heeft één 'ingredient'
    }


    protected $fillable = [
        'dish_id',
        'ingredient_id',
        'quantity',
        'measurement_unit',
    ];


}

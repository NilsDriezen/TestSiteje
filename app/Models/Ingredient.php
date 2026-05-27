<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    // relatie tussen de models
    public function dish_ingredients()
    {
        return $this->hasMany(Dish_ingredient::class);   // een ingredient heeft geen of meerdere 'dish_ingredients'
    }

    public function cocktail_ingredients()
    {
        return $this->hasMany(Cocktail_ingredient::class);   // een ingredient heeft geen of meerdere 'cocktail_ingredients'
    }

    public function cookie_ingredients()
    {
        return $this->hasMany(Cookie_ingredient::class);   // een ingredient heeft geen of meerdere 'cookie_ingredients'
    }

    /**
     * Zoekfunctionaliteit: doorzoek alle kolommen van de tabel */

    public function scopeSearchColumns($query, $search = '%', $columns = [])
    {
        if (empty($columns)) {
            // If no specific columns are provided, use fillable columns
            $columns = $this->fillable;
        }

        return $query->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

    protected $fillable = [
        'name',
        'price',
    ];


}

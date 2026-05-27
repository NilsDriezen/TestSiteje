<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    // relatie tussen de models
    public function menu_dishes()
    {
        return $this->hasMany(Menu_dish::class);   // een dish heeft geen of meerdere 'menu_dishes'
    }

    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault();   // een dish heeft één 'course'
    }

    public function dish_ingredients()
    {
        return $this->hasMany(Dish_ingredient::class);   // een dish heeft geen of meerdere 'dish_ingredients'
    }

    public function cocktails()
    {
        return $this->hasMany(cocktail::class);   // een dish heeft geen of meerdere 'cocktails'
    }

    public function cookies()
    {
        return $this->hasMany(cookie::class);   // een dish heeft geen of meerdere 'cookies'
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

    public function scopeSearchName($query, $search = '%')
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('recipe_tag', 'like', "%{$search}%");

    }
    // menu count
    public function menusCount()
    {
        return $this->menu_dishes->count();
    }

    public function scopeMaxCalorie($query, $calorie = 1000)
    {
        return $query->where('calorie', '<=', $calorie);
    }

    public function scopeMaxPreparationTime($query, $preparation_time = 100)
    {
        return $query->where('preparation_time', '<=', $preparation_time);
    }


    protected $fillable = [
        'name',
        'instruction',
        'preparation_time',
        'serving',
        'recipe_tag',
        'comment',
        'calorie',
        'active',
        'course_id',
        'path',
        'cooking_time',
    ];

    public function ingredients()
    {
        //return $this->belongsToMany(Ingredient::class, 'dish_ingredients');
        return $this->belongsToMany(Ingredient::class, 'dish_ingredients')
            ->withPivot('quantity', 'measurement_unit');
    }

    // check if course is referenced in any dish
    public function isReferenced()
    {
        return $this->menu_dishes()->exists();
    }















}

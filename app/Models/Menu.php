<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $dates = ['date'];

    // relatie tussen de models
    public function reservation_menus()
    {
        return $this->hasMany(Reservation_menu::class);   // een menu heeft geen of meerdere 'reservation_menus'
    }

    public function getDateAttribute($value)
    {
        if ($value == null) return null;
        Carbon::setLocale('nl');    // zet de locale naar Nederlands (voor de maandnamen
        return Carbon::parse($value)->translatedFormat('Y-m');
    }

    public function setDateAttribute($value)
    {
        if ($value) {
//            Carbon::setLocale('nl');
            $this->attributes['date'] = Carbon::createFromDate($value)->format('Y-m-d');
        } else {
            $this->attributes['date'] = null;
        }
    }

    public function menu_dishes()
    {
        return $this->hasMany(Menu_dish::class);   // een menu heeft geen of meerdere 'menu_dishes'
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

    public function voorgerechtDish()
    {
        return $this->menu_dishes()->whereHas('dish', function ($query) {
            $query->where('course_id', 1);
        })->first()->dish ?? null;
    }

    public function tussengerechtDish()
    {
        return $this->menu_dishes()->whereHas('dish', function ($query) {
            $query->where('course_id', 2);
        })->first()->dish ?? null;
    }

    public function hoofdgerechtDish()
    {
        return $this->menu_dishes()->whereHas('dish', function ($query) {
            $query->where('course_id', 3);
        })->first()->dish ?? null;
    }

    public function dessertDish()
    {
        return $this->menu_dishes()->whereHas('dish', function ($query) {
            $query->where('course_id', 4);
        })->first()->dish ?? null;
    }

    protected $fillable = [
        'name',
        'is_veggie',
        'price_3_course',
        'price_4_course',
        'date',
    ];

}

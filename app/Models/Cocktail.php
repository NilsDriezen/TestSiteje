<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    // relatie tussen de models
    public function dish()
    {
        return $this->belongsTo(Dish::class)->withDefault();   // een cocktail heeft één 'dish'
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
}

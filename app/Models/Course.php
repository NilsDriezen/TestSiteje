<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['type'];  // vulbaar veld

    // relatie tussen de models
    public function dishes()
    {
        return $this->hasMany(Dish::class);   // een course heeft geen of meerdere 'dishes'
    }

     public function scopeSearchName($query, $search = '%')
    {
        return $query->where('type', 'like', "%{$search}%");
    }


}

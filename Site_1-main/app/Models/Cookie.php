<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cookie extends Model
{
    use HasFactory;

    // relatie tussen de models
    public function dish()
    {
        return $this->belongsTo(Dish::class)->withDefault();   // een cookie heeft één 'dish'
    }

    public function cookie_order_lines()
    {
        return $this->hasMany(Cookie_order_line::class);   // een cookie heeft geen of meerdere 'cookie_order_lines'
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
        'description',
        'price',
        'picture_path',
        'stock',
        'active',
        'dish_id'
    ];


}

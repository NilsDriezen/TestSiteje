<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

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
                if (str_contains($column, 'created_at')) {
                    str_replace(['_', '/'], '-', $search);
                    $d = explode('-', $search);
                    // check maand = d[1]
                    if (count($d) == 2) {
                        if (strlen($d[1]) == 1) {
                            $d[1] = $d[1] . '_';
                        }
                    }
                    // check jaar = d[2]
                    if(count($d) == 3) {
                        $d[2] = $d[2] . '___';
                        // enkel de eerste 4 karakters van $d[2] worden gebruikt
                        $d[2] = substr($d[2], 0, 4);
                    }
                    $search = implode('-', array_reverse($d));
                }
                $query->orWhere($column, 'like', "%{$search}%");
            }
        });
}



    protected $fillable = [
        'name',
        'message',
        'is_approved',
        'is_new',
        'created_at',
        'updated_at',
        'date', //(datum niet aanpasbaar maken)
    ];


    public function setDateAttribute($value)
    {
        // Splits de waarde op "-"
        $parts = explode('-', $value);

        // Als het eerste deel groter is dan 12, gaan we ervan uit dat het 'Y-m-d' formaat is
        if ((int)$parts[0] > 31) {
            $created_at = Carbon::createFromFormat('Y-m-d', $value);
        } else {
            // Anders gaan we ervan uit dat het 'd-m-Y' formaat is
            $created_at = Carbon::createFromFormat('d-m-Y', $value);
        }

        // Zet de datum om naar een datumreeks en wijs deze toe aan het 'created_at' attribuut
        $this->attributes['created_at'] = $created_at ? $created_at->toDateString() : null;
    }

    public function getDateAttribute($value)
    {
        // Format the date to 'd-m-Y' format when retrieving from database
        return Carbon::parse($value)->format('d-m-Y');
    }


}

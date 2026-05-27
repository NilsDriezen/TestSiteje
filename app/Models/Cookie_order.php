<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cookie_order extends Model
{
    use HasFactory;

    public function getCookies()
    {
        $cookies = collect();

        // Loop door elke cookie order line van deze cookie order
        $this->cookie_order_lines->each(function ($cookieOrderLine) use ($cookies) {
            // Voeg de cookie van deze regel toe aan de verzameling cookies
            $cookies->push($cookieOrderLine->cookie);
        });

        // Retourneer de verzameling van cookies
        return $cookies;
    }


    public function cookie_order_lines()
    {
        return $this->hasMany(Cookie_order_line::class);   // een cookie_order heeft geen of meerdere 'cookie_order_lines'
    }


// zoek in de fillable kolommen en in de cookie naam

    public function scopeSearchColumns($query, $search = '%', $columns = [])
    {
        if (empty($columns)) {
            // If no specific columns are provided, use fillable columns
            $columns = $this->fillable;
        }

        return $query->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                if (str_contains($column, 'date')) {
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
        })->orWhereHas('cookie_order_lines.cookie', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        });
    }



    protected $fillable = [
        'date_pick_up',
        'time_slot',
        'comment',
        'customer_name',
        'customer_phone_number',
        'customer_email',
        'active',
        'total_price',
        'is_new',
    ];

    public function setDatePickUpAttribute($value)
    {
        // Splits de waarde op "-"
        $parts = explode('-', $value);

        // Als het eerste deel groter is dan 12, gaan we ervan uit dat het 'Y-m-d' formaat is
        if ((int)$parts[0] > 31) {
            $date_pick_up = Carbon::createFromFormat('Y-m-d', $value);
        } else {
            // Anders gaan we ervan uit dat het 'd-m-Y' formaat is
            $date_pick_up = Carbon::createFromFormat('d-m-Y', $value);
        }

        // Zet de datum om naar een datumreeks en wijs deze toe aan het 'date_pick_up' attribuut
        $this->attributes['date_pick_up'] = $date_pick_up ? $date_pick_up->toDateString() : null;
    }




    public function getDatePickUpAttribute($value)
    {
        // Format the date to 'd-m-Y' format when retrieving from database
        return Carbon::parse($value)->format('d-m-Y');
    }


}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Agenda;
use App\Models\Reservation_menu;

class Reservation extends Model {
    use HasFactory;

    public function reservation_menus()
    {
        return $this->hasMany(Reservation_menu::class);   // een reservation heeft geen of meerdere 'reservation_menus'
    }

    /* Zoekfunctionaliteit: doorzoek alle kolommen van de tabel */

    public static function getAllReservations()
    {
        $reservations_all =  DB::table('reservations')
            ->select('date', 'time_slot', 'number_of_person')
            ->orderBy('date', 'desc')
            ->get();

        return $reservations_all;
    }

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
        'date',
        'time_slot',
        'number_of_person',
        'comment',
        'customer_name',
        'customer_phone_number',
        'customer_email',
        'active',
        'is_four_course',
        'is_new',
    ];

    public function getDateAttribute($value)
    {
        // Format the date to 'd-m-Y' format when retrieving from database
        return Carbon::parse($value)->format('d-m-Y');
    }

}

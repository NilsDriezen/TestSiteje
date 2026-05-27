<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    // zet de datum in het formaat 'Y-m-d' bij het ophalen in de database
    public function getDateExceptionAttribute($value)
    {
        if ($value) {
            // Format the date to 'd-m-Y' format when retrieving from database
            return Carbon::parse($value)->format('d-m-Y');
        } else {
            // Return an empty string if the value is null
            return null;
        }
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
        'day_of_week',
        'date_exception',
        'time_start',
        'time_end',
        'closed',
        'type',
    ];


    /**
     * Zoekfunctionaliteit om reguliere openingstijden op te halen
     */
    public function scopeRegularOpeningHours($query)
    {
        return $query->whereNull('date_exception');
    }


 // Bepaal de dagen van de maand om een kalender te maken
    public static function getDaysOfMonth($month = null, $year = null)
    {
        // Bepaal de huidige maand en jaar als geen waarden zijn meegegeven
        if ($month === null || $year === null) {
            $month = date('n'); // huidige maand (1-12)
            $year = date('Y'); // huidig jaar
        }

// Bepaal de eerste dag van de maand
        $firstDayOfMonth = strtotime("$year-$month-01");
        $firstDayOfWeek = date('N', $firstDayOfMonth); // 1 (maandag) t/m 7 (zondag), op welke dag valt de eerste dag van de maand

// Bepaal het aantal dagen in de maand
        $numDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Maak een array voor de kalender
        $calendar = [];

// Voeg de dagen van de maand toe aan de kalender array
        $day = 1;
        for ($week = 0; $day <= $numDaysInMonth; $week++) {
            for ($i = 1; $i <= 7; $i++) {
                if ($week === 0 && $i < $firstDayOfWeek) {
                    // Vul de dagen van de vorige maand in voor de eerste week
                    $calendar[$week][] = null;
                } else {
                    if ($day <= $numDaysInMonth) {
                        $calendar[$week][] = $day++;
                    } else {
                        // Vul de dagen van de volgende maand in voor de laatste week
                        $calendar[$week][] = null;
                    }
                }
            }
        }

// Voeg extra rij toe als dat nodig is
        if (count($calendar[count($calendar) - 1]) < 7) {
            $calendar[count($calendar)] = array_fill(0, 7, null);
        }

// return de kalender array
        return $calendar;

    }

    // Functie om de reguliere openingstijden binnen een bepaald aantal dagen op te halen

    public static function getRegularOpeningDays($type = null, $numDays = 90)
    {
        // Haal alle reguliere openingstijden op
        $regular_opening_hours = self::regularOpeningHours()->get();

        // Filter op type als deze is gespecificeerd
        if ($type !== null) {
            $regular_opening_hours = $regular_opening_hours->where('type', $type);
        }

        // Bepaal de begindatum (vandaag) in UTC-tijdzone
        $startDate = now()->setTimezone('UTC')->startOfDay();

        // Bepaal de einddatum (het aantal dagen vanaf vandaag) in UTC-tijdzone
        $endDate = now()->setTimezone('UTC')->addDays($numDays)->endOfDay();

        // Haal alle uitzonderingsdagen op van het type dat is gespecificeerd
        $exceptional_opening_hours = self::whereNotNull('date_exception')->get();
          if ($type !== null) {
                $exceptional_opening_hours = $exceptional_opening_hours->where('type', $type);
            }
//          dump($exceptional_opening_hours->toArray());

        // Lijst om reguliere openingstijden binnen de komende dagen op te slaan
        $opening_days = [];

        // Loop door elke datum binnen de periode van het opgegeven aantal dagen
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Initialiseer een array om reguliere openingstijden voor de huidige dag op te slaan
            $dayOpeningHours = [];

            // Controleer of de huidige dag van de week overeenkomt met de reguliere openingstijden
            foreach ($regular_opening_hours as $opening_hour) {
               if ($date->format('l') === $opening_hour->day_of_week) {
    // Voeg de start- en eindtijd toe aan de lijst met reguliere openingstijden voor deze dag
    $dayOpeningHours[] = [
        'start_time' => $opening_hour->time_start,
        'end_time' => substr($opening_hour->time_end, 0, 5),
        'type' => $opening_hour->type,
        // wanneer er een time_start is, voeg een tijdslot toe
        'time_slot' => $opening_hour->time_start ? substr($opening_hour->time_start, 0, 5) . ' - ' . substr($opening_hour->time_end, 0, 5) : null,
    ];
}
            }

            // Controleer of er uitzonderingen zijn voor deze dag
            foreach ($exceptional_opening_hours as $exceptional_hour) {
                if ($date->format('d-m-Y') === date('d-m-Y', strtotime($exceptional_hour->date_exception))) {                    // Als de uitzondering aangeeft dat het restaurant open is, voeg deze toe aan de lijst met reguliere openingstijden
                    if (!$exceptional_hour->closed) {
                        $dayOpeningHours[] = [
                            'start_time' => $exceptional_hour->time_start,
                            'end_time' => $exceptional_hour->time_end,
                            'type' => $exceptional_hour->type,
                            'time_slot' => substr($exceptional_hour->time_start, 0, 5) . ' - ' . substr($exceptional_hour->time_end, 0, 5),
                        ];
                    } else {
                        // Als het restaurant gesloten is, voeg geen openingstijden toe voor deze dag
                        $dayOpeningHours = [];
                    }
                    break;
                }
            }

            // Als er reguliere openingstijden zijn gevonden voor deze dag, voeg deze toe aan de lijst
            if (!empty($dayOpeningHours)) {
                $opening_days[$date->format('Y-m-d')] = $dayOpeningHours;
            }
        }

        return $opening_days;
    }

    // functie om de dagen (getal) van 1 maand te vinden waarop het restaurant open is
    public static function findOpenDaysOfMonth($openingDays, $type = null, $month = null, $year = null)
    {
        // Als de maand of het jaar niet is opgegeven, gebruik dan de huidige maand en het huidige jaar
        if ($month === null) {
            $month = now()->month;
        }
        if ($year === null) {
            $year = now()->year;
        }

        // Maak een lege array om de dagen waarop het restaurant open is op te slaan
        $openDaysOfMonth = [];

        // Loop door elke dag van de maand
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            // Formatteer de datum in hetzelfde formaat als de sleutels in $openingDays
            $formattedDate = $date->format('Y-m-d');

            // Controleer of de huidige datum voorkomt in $openingDays
            if (isset($openingDays[$formattedDate])) {
                // Als het type niet is gespecificeerd, voeg de huidige datum toe aan de lijst met open dagen
                // Als het type is gespecificeerd, controleer of de openingstijden van dat type zijn voor deze datum
                if ($type === null || in_array($type, array_column($openingDays[$formattedDate], 'type'))) {
                    $openDaysOfMonth[] = $date->format('d');
                }
            }
        }

        return $openDaysOfMonth;
    }

}

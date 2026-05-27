<?php

namespace App\Livewire\Admin;

use App\Models\Agenda; // Aanpassen!
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Agendabeheer extends Component  // (app livewire admin ....) // Aanpassen!
{
  // agenda
    public $typeAgenda = 'koekjes';
    public $showModal = false;
    public $uitzondering = false;

    public $monthArray = [];
    public $openDaysOfMonth = [];
    public $openingDays = [];
    public $month;
    public $year;
    public  $selectedDates = [];
    public $selectedTimes = [];
    public $selectedDay;
    public  $timeSlots = [];
    public $selectedTimeSlots = [];
    public  $selectedDayd;

    // layout
    public  $orderBy = 'day_of_week';
    public  $orderAsc = true ;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at', 'id' ]; // Attributes to exclude
    public $textareaColumns = ['']; // kolommen waarvoor textarea moet genomen worden ipv text
    public $booleanColumns = ['closed']; // kolommen waarvoor checkbox moet genomen worden ipv text
    public $editing = false;
    public $editingLineId;
    public $perPage = 5;



    use WithPagination;
    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }





// variabelen aanpassen!
    public
        $newLineDate_exception,
        $newLineDay_of_week
    ;
    public $newLineType = 'koekjes';

// validatie regels

// Booleans opsommen en naar 0 zetten
    public $newLineClosed = false;  //laten staan

// validaties voor verplichte velden
    #[Validate('required|min:3|max:300', // Aanpassen!
        attribute: 'type' // Aanpassen!
    )]

//     validaties voor tijdsvelden
//    #[Validate('required', attribute: 'starttijd'
//    )]
    public $newLineTime_start;
//    #[Validate('required', attribute: 'eindtijd')]
    public $newLineTime_end;


    // hernoem attributen
    protected $validationAttributes = [
    'newLineDate_exception' => 'uitzonderingsdatum',
    'newLineDay_of_week' => 'dag van de week',
        'newLine' => 'name',
        'newLinePrice' => 'Prijs',
        'newLineTime_start' => 'starttijd',
        'newLineTime_end' => 'eindtijd',
];

    // uitzondering op de validationrules
    public function rules()
    {

        return [
            'newLineTime_start' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->newLineClosed && $value !== '00:00') {
                        $fail('Starttijd moet 00:00 zijn bij een sluitingsdag.');
                    }
                    if ($this->newLineTime_end && $value >= $this->newLineTime_end) {
                        $fail('Starttijd moet kleiner zijn dan eindtijd.');
                    }
                },
            ],
            'newLineTime_end' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->newLineClosed && $value !== '23:59') {
                        $fail('Eindtijd moet 23:59 zijn bij een sluitingsdag.');
                    }
                    if ($this->newLineTime_start && $value <= $this->newLineTime_start) {
                        $fail('Eindtijd moet groter zijn dan starttijd.');
                    }
                },
            ],
            'newLineDate_exception' => 'required_without:newLineDay_of_week',
            'newLineDay_of_week' => 'required_without:newLineDate_exception',
            'newLineClosed' => "required:Agendas,name,{$this->editingLineId}",

        ];

    }

    public function editLine($id) // Aanpassen!
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Agenda::findOrFail($id);

        // zet de datum om van 01-01-2021 naar 2021-01-01 indien er een datum is
        $this->newLineDate_exception = $line->date_exception ? Carbon::createFromFormat('d-m-Y', $line->date_exception)->format('Y-m-d') : null;
//      $this->newLineDate_exception = Carbon::createFromFormat('d-m-Y', $line->date_exception)->format('Y-m-d');
//        dump($this->newLineDate_exception);
        $this->newLineDay_of_week = $line->day_of_week;
        $this->newLineTime_start = $line->time_start;
        $this->newLineTime_end = $line->time_end;
        $this->newLineClosed = $line->closed;
        $this->newLineType = $line->type;
//        dump($line->date_exception);
        if ($line->date_exception) {
            $this->uitzondering = true;
        }
        $this->showModal = true;
    }

    public function openModal()
    {
        $this->resetValues();
        $this -> newLineType = $this->typeAgenda;
        $this->showModal = true;
    }

public function createOrUpdate()
{
    $this->validate();

    $data = [
        'date_exception' => $this->newLineDate_exception,
        'day_of_week' => $this->newLineDay_of_week,
        'time_start' => $this->newLineTime_start,
        'time_end' => $this->newLineTime_end,
        'closed' => $this->newLineClosed,
        'type' => $this->newLineType,
    ];

    if ($this->editing) {
        $line = Agenda::findOrFail($this->editingLineId);
        $line->update($data);

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>Openingstijd</i></b> is aangepast",
        ]);
        $this->resetValues();
    } else {
        $reservations = \App\Models\Reservation::where('date', $this->newLineDate_exception)->get();
        if ($reservations->count() > 0 && $this->newLineClosed && $this->newLineType == 'reservaties'   ){
            $this->dispatch('swal:confirm', [
                'title' => 'Er zijn reservaties op deze dag!',
                'text' => 'Weet je zeker dat je deze sluitingsdag wilt instellen?',
                'cancelButtonText' => 'Nee',
                'confirmButtonText' => 'Ja',
                'icon' => 'warning',
                'next' => [

                    'event' => 'addException',
                ]
            ]);
        }
        else {
            $newLine = Agenda::create($data);
            $namePref = $this->newLineDate_exception ? 'Uitzonderingsdatum' : 'Vaste dag van de week';
            $name =  __($this->newLineDay_of_week) ?? date('d-m-Y', strtotime($this->newLineDate_exception));
            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "$namePref <b>$name</b> is toegevoegd",
            ]);
            $this->resetValues();
        }
        }
}
    // voeg een uitzondering toe, met javascript confirmatie
    #[On('addException')]
    public function addException()
    {
        $this->validate();
        $data = [
            'date_exception' => $this->newLineDate_exception,
            'time_start' => $this->newLineTime_start,
            'time_end' => $this->newLineTime_end,
            'closed' => $this->newLineClosed,
            'type' => $this->newLineType,
        ];

        $newLine = Agenda::create($data);

        $name = date('d-m-Y', strtotime($this->newLineDate_exception));

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Sluitingsdag <b>$name</b> is toegevoegd",
        ]);
        $this->resetValues();
    }

    // reset all the values and error messages
    public function resetValues() // Aanpassen!
    {
        $this ->reset('newLineDate_exception');
        $this ->reset('newLineDay_of_week');
        $this ->reset('newLineTime_start');
        $this ->reset('newLineTime_end');
        $this ->reset('newLineClosed');
        $this ->reset('newLineType');
        $this->timeSlots = [];
        $this->selectedTimes = [];
        $this->selectedTimeSlots = [];
        $this->selectedDay = null;
        $this->selectedDayd = null;
        $this->showModal = false;
        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
        $this->resetPage();
        $this->reset('editingLineId');
    }

    public function updated($property, $value)
    {
        // $property: The name of the current property being updated
        // $value: The value about to be set to the property
        if (in_array($property, ['perPage',  'orderBy', 'orderAsc', 'uitzondering']))
            $this->resetPage();
    }


    // delete a item with java script
    #[On('delete-line')]

    public function delete($id)
    {
        $line = Agenda::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $name = $line->date_exception ?? __($line->day_of_week);
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b>$name</b> is verwijderd",
        ]);
    }

    public function nextMonth()
    {
        $this->month++; // verhoog de maand met 1
        if ($this->month > 12) {
            $this->month = 1;
            $this->year++;
        }
        $this->monthArray = Agenda::getDaysOfMonth($this->month, $this->year);
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, $this->typeAgenda,$this->month,$this->year );
        $this->selectedDay = null;
        $this->selectedDayd = null;
    }

    public function prevMonth()
    {
        if (now()->month == $this->month && now()->year == $this->year) {
            return;
        }

        $this->month--; // verlaag de maand met 1
        if ($this->month < 1) {
            $this->month = 12;
            $this->year--;
        }
        $this->monthArray = Agenda::getDaysOfMonth($this->month, $this->year);
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, $this->typeAgenda,$this->month,$this->year);
        $this->selectedDay = null;
        $this->selectedDayd = null;
    }


    public function selectDayTime($day = 32)
    {
        // stop de functie als de dag niet in de open dagen van de maand zit
        if (!in_array($day, $this->openDaysOfMonth)) {
            return;
        }

        $this->selectedTimes = [];
        $this->timeSlots = [];
        $this->selectedTimeSlots = [];
        $year = $this->year;
        $month = $this->month;
        $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
        $this ->selectedDay = $date;
        $this-> selectedDayd = $day;
        $this->selectedTimes = $this->openingDays[$date];

        // Iterate over selectedTimes and get the time_slot
        foreach ($this->selectedTimes as $timeSlot) {
            // Geef time_slot value, als er geen is dan is het een lege string
//            dump($timeSlot);
//            dump ($timeSlot['time_slot']);

            $timeSlotValue = $timeSlot['time_slot'] ?? 'Geen tijdslot ingevuld';
            // Gebruik $timeSlotValue in view
            $this->timeSlots[] = $timeSlotValue;
            // sort the array
            sort($this->timeSlots);
        }
    }

    // functie om uitzondering aan/uit te zetten
  public function setUitzondering($value)
{
    $soort = $this->typeAgenda;
    $this->uitzondering = $value;
    $this-> resetValues();
    $this->newLineType = $soort;
    $this->showModal = true;
}

    public function toggleClosed(Agenda $id)
    {
//        dump($id);
        $id->update([
            'closed' => !$id->closed
        ]);
    }

public $calendarVisible = true;
    public function setCalendarVisible($value)
    {
        $this->calendarVisible = $value;
        $this->timeSlots = [];
        $this->selectedDay = null;
        $this->selectedDayd = null;

    }

public function toggleTimeBasedOnClosed()
{
    if ($this->newLineClosed) {
        $this->newLineTime_start = "00:00";
        $this->newLineTime_end = "23:59";
    } else {
        $this->newLineTime_start = null;
        $this->newLineTime_end = null;
    }
}

    public function mount(){
// Haal de openingstijden op van de Agenda
        $openingDays = Agenda::getRegularOpeningDays('koekjes',90);

        // Doorgeven aan variabele, openingstijden
        $this->openingDays = $openingDays;

        $month = date('n');
        $year = date('Y');
        $this->month = $month;
        $this->year = $year;
        // Haal de dagen van de maand op van de agenda, raster
        $monthArray = Agenda::getDaysOfMonth($month,$year) ;
        $this->monthArray = $monthArray;
        // haal de open dagen van de maand op, dag = getal
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'koekjes' );
    }



    #[Layout('layouts.huiskamer', ['title' => 'Agenda', 'description' => 'Beheer van openingstijden'])]
    public function render()
    {
        // Bepaal de sorteer kolom, naargelang dag of uitzondering is ingevuld
        if ($this->uitzondering) {
            $this->orderBy = 'date_exception';
        } else {
            $this->orderBy = 'day_of_week';
        }

        // Gebruik de filterfunctie om het juiste type koekjes/reservaties weer te geven
        $this->search = $this->typeAgenda;

        // Zoek de records op basis van de zoek/filterterm
        $query = Agenda::searchColumns($this->search);

        // De kolom day_of_week bevat weekdagen zoals maandag, zondag, zaterdag..., sorteer deze op de juiste volgorde
        if ($this->orderBy === 'day_of_week') {
            $query = $query->orderByRaw('FIELD(day_of_week, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday") ' . ($this->orderAsc ? 'ASC' : 'DESC'));
        } else {
            $query = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
        }

        // Voeg een where-clausule toe om alleen records weer te geven waar date_exception >= vandaag
        $query->where(function($query) {
            $query->where('date_exception', '>=', now()->toDateString())
                ->orWhereNull('date_exception');
        });

        // Determine the columns based on include/exclude attributes
        $firstLine = $query->first();
        if ($firstLine) {
            $attributes = array_keys($query->first()->getAttributes());
            $this->columns = array_merge($this->includeAttributes, array_diff($attributes, $this->excludeAttributes));
        } else {
            $this->columns = [];
        }

        // Wanneer uitzondering is aangevinkt, dan moet de where-clausule + sortering worden aangepast
        if ($this->uitzondering) {
            $this->orderBy = 'date_exception';
            $query->whereNotNull('date_exception');
        } else {
            $this->orderBy = 'day_of_week';
            $query->whereNull('date_exception');
        }

        // Pagineer
        $lines = $query->paginate($this->perPage);

        // Haal alle reguliere openingstijden op met de zoek scope regularOpeningHours  (date_exception is null)
        $regular_opening_hours = Agenda::regularOpeningHours()->get();
        // Haal alle uitzonderlijke openingstijden op
        $exceptional_opening_hours = Agenda::whereNotNull('date_exception')->get();

        // Haal de openingsdagen met tijdsloten op van de Agenda, rekening houdend met de typeAgenda en aantal dagen
        $openingDays = Agenda::getRegularOpeningDays($this->typeAgenda,90);

        // Geef door aan variabele openingDays
        $this->openingDays = $openingDays;

        // Haal de dagen van de maand op van de agenda om raster te maken
        $monthArray = Agenda::getDaysOfMonth($this->month,$this->year) ;
        $this->monthArray = $monthArray;

        // haal de open dagen van de maand op (dag = getal)
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, $this->typeAgenda ,$this->month,$this->year);


        return view('livewire.admin.agendabeheer', compact('lines', 'regular_opening_hours','openingDays','exceptional_opening_hours' , 'monthArray' ,  'openingDays'));
    }

}

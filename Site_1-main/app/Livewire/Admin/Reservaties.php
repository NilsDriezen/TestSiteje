<?php

namespace App\Livewire\Admin;

use App\Models\Agenda;
use App\Models\Reservation;
use App\Models\Reservation_menu;

// Aanpassen!
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;


class Reservaties extends Component
{

    public $orderBy = 'date';
    public $orderAsc = true;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at', 'id', 'active', 'is_new']; // Attributes to exclude
    public $textareaColumns = ['comment']; // kolommen waarvoor textarea moet genomen worden ipv text
    public $booleanColumns = ['active', 'is_four_course', 'is_new']; // kolommen waarvoor checkbox moet genomen worden ipv text
    public $editing = false;
    public $editingLineId;
    public $perPage = 15;
    public $showToday = false;
    public $newLineNumberOfPerson;

    public $newLineIs_new;

    use WithPagination;

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    // validatie regels
    public
        $newLine,
        $newLineComment,
        $newLineCustomer_name,
        $newLineCustomer_phone_number,
        $newLineQuantity,
        $newLineCustomer_email; // Aanpassen!

    // Booleans
    public $newLineActive = 0,
        $newLineIs_four_course = 0;  //laten staan

    #[Validate('nullable|numeric')]
    public $newLineNumber_of_person;
    #[Validate('required|date_format:Y-m-d')]
    public $newLineDate;
    #[Validate('required|date_format:H:i:s')]
    public $newLineTime_slot;


    // uitzondering op de unique rule bij edit
    public function rules()
    {
        return [
            'newLineCustomer_name' => "required|min:3|max:30|unique:cruds,name,$this->editingLineId", // Aanpassen!
        ];
    }


    // $validationAttributes is used to replace the attribute name in the error message
    protected $validationAttributes = [
        'newLineCustomer_name' => 'Naam',
        'newLineNumber_of_person' => 'Aantal personen',
        'newLineDate' => 'Datum',
        'newLineTime_slot' => 'Tijdslot',

    ];

    public function editLine($id): void // Aanpassen!
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Reservation::findOrFail($id); // Aanpassen!


        $this->newLine = $line->name;
        $this->newLineDate = $line->date;
        $this->newLineTime_slot = $line->time_slot;
        $this->newLineNumber_of_person = $line->number_of_person;
        $this->newLineComment = $line->comment;
        $this->newLineCustomer_name = $line->customer_name;
        $this->newLineCustomer_phone_number = $line->customer_phone_number;
        $this->newLineCustomer_email = $line->customer_email;
        $this->newLineActive = $line->active;
        $this->newLineIs_four_course = $line->is_four_course;




    }

    public function createOrUpdate()
    {
//        $this->validateOnly('newLine');
//        $this->validateOnly('newLineDescription');


        $this->validate();

        $data = [                                                                       // Aanpassen!
            'date' => $this->newLineDate,
            'time_slot' => $this->newLineTime_slot,
            'number_of_person' => $this->newLineNumber_of_person,
            'comment' => $this->newLineComment,
            'customer_name' => $this->newLineCustomer_name,
            'customer_phone_number' => $this->newLineCustomer_phone_number,
            'customer_email' => $this->newLineCustomer_email,
            'active' => $this->newLineActive,
            'is_four_course' => $this->newLineIs_four_course,];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Reservation::findOrFail($this->editingLineId);
            $line->update($data);


            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->id) . "</i></b> is aangepast",
            ]);
        } else {
            // Create a new record in create mode

            $newLine = Reservation::create($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($newLine->id) . "</i></b> is toegevoegd",
            ]);
        }

        $this->resetValues();
    }

    // reset all the values and error messages
    public function resetValues() // Aanpassen!
    {
        $this->reset('newLineDate');
        $this->reset('newLineTime_slot');
        $this->reset('newLineNumber_of_person');
        $this->reset('newLineComment');
        $this->reset('newLineCustomer_name');
        $this->reset('newLineCustomer_phone_number');
        $this->reset('newLineCustomer_email');
        $this->reset('newLineActive');
        $this->reset('newLineIs_four_course');


        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
    }

    public function updated($property, $value)
    {
        // $property: The name of the current property being updated
        // $value: The value about to be set to the property        if (in_array($property, ['perPage', 'search']))        $this->resetPage();
    }


    // delete a item with java script
    #[On('delete-line')]
    public function delete($id)
    {
        $line = Reservation::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is verwijderd",
        ]);
    }

    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    public function mount()
    {
        // Haal de openingstijden op van de Agenda
        $openingDays = Agenda::getRegularOpeningDays('reservaties', 90);

        // Filter de openingstijden
        $this->openingDays = $openingDays;

        $month = date('n');
        $year = date('Y');
        $this->month = $month;
        $this->year = $year;
        // Haal de dagen van de maand op van de agenda
        $monthArray = Agenda::getDaysOfMonth($month, $year);
        $this->monthArray = $monthArray;

        // haal de open dagen van de maand op
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'reservaties');
    }

    public function resetIsNew()
    {
        $lines = Reservation::where('is_new', true)->get();
        foreach ($lines as $line) {
            $line->update([
                'is_new' => false
            ]);
        }
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Alle nieuwe reservaties zijn bevestigd",
        ]);
        return redirect()->to(route('admin.reservaties'));
    }

    public function toggleShowToday()
    {
        $this->showToday = !$this->showToday;
    }

    #[Layout('layouts.huiskamer', ['title' => 'Reservatiebeheer', 'description' => ''])]
    public function render()
    {
        $query = Reservation::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

        if ($this->showToday) {
            $query->whereDate('date', now()->format('Y-m-d'));
        }

        $query->searchColumns($this->search);

        // Determine the columns based on include/exclude attributes
        $firstLine = $query->first();
        if ($firstLine) {
            $attributes = array_keys($query->first()->getAttributes());
            $this->columns = array_merge($this->includeAttributes, array_diff($attributes, $this->excludeAttributes));
        } else {
            $this->columns = [];
        }

        // Paginate the results after applying the scope
        $lines = $query->paginate($this->perPage);
        foreach ($lines as $line) {
            $reservationMenu = Reservation_Menu::where('reservation_id', $line->id)->first();
            $line->quantity = $reservationMenu ? $reservationMenu->quantity : 0;
        }

        $regular_opening_hours = Agenda::regularOpeningHours()->get();
        $openingDays = Agenda::getRegularOpeningDays();
        $exceptional_opening_hours = Agenda::whereNotNull('date_exception')->get();
        $reservations_all = Reservation::getAllReservations();

        $selectedTimes = [];
        $timeSlots = [];
        $selectedDay = null;
        $selectedTime = null;
        $selectedTimeSlots = [];

        return view('livewire.admin.reservaties', compact('lines', 'reservations_all', 'regular_opening_hours', 'openingDays', 'exceptional_opening_hours', 'selectedTimes', 'timeSlots', 'selectedDay', 'selectedTime', 'selectedTimeSlots'));
    }


}

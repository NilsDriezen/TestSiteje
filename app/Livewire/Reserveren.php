<?php

namespace App\Livewire;

use App\Models\Reservation;
use App\Models\Reservation_menu;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use carbon\Carbon;
use App\Models\Agenda;
use App\Models\Menu;
use Livewire\Attributes\Validate;

class Reserveren extends Component
{
    public $newLineDate;
    public $newLineTimeSlot;
    #[Validate('required|integer|min:1')]
    public $newLineNumberOfPerson;

    public $newLineQuantity;

    public $newLineIsFourCourse = false;

    public $newLineComment;
    #[Validate('required|min:3|max:50', as: 'Naam')]
    public $newLineCustomerName;
    #[Validate('required|regex:/^(\+?[0-9\s\-]{10,20})$/', as: 'Telefoonnummer')]
    public $newLineCustomerPhoneNumber;
    #[Validate('required|email', as: 'E-mail')]
    public $newLineCustomerEmail;

    public $newLineActive;
    public $newLineCreatedAt;
    public $newLineUpdatedAt;
    public $newLineIsNew = true;


    // sort properties
    public $orderBy = 'date';
    public $orderAsc = true;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = []; // Attributes to exclude
    public $perPage = 5;

    public $textareaColumns = ['description']; // kolommen waarvoor textarea moet genomen worden ipv text
    public $booleanColumns = ['active']; // kolommen waarvoor checkbox moet genomen worden ipv text
    public $hiddenColumns = ['id', 'picture_path', 'active']; // kolommen die niet getoond worden

    // Calendar

    public $monthArray;
    public $openingDays;

    // maand en jaar van de agenda

    public $month;
    public $year;
    public $openDaysOfMonth;
    public $filteredOpeningDays = [];
    public $uniqueMonths = [];
    public  $selectedDates = [];
    public  $selectedTimes = [];
    public $selectedDayd = 32;

    public function mount()
    {
        // Haal de openingstijden op van de Agenda
        $openingDays = Agenda::getRegularOpeningDays('reservaties',90);

        // Filter de openingstijden
        $this->openingDays = $openingDays;

        $month = date('n');
        $year = date('Y');
        $this->month = $month;
        $this->year = $year;
        // Haal de dagen van de maand op van de agenda
        $monthArray = Agenda::getDaysOfMonth($month,$year) ;
        $this->monthArray = $monthArray;

        // haal de open dagen van de maand op
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'reservaties' );
    }

    // een functie die in $openingsDays zoekt naar de geselecteerde dag en de tijden van die dag teruggeeft
    public function selectDayTime($day = 32) {
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
        //$this->form->date = $date;
        $this->selectedTimes = $this->openingDays[$date];
        // Iterate over selectedTimes and get the time_slot
        foreach ($this->selectedTimes as $timeSlot) {
            // Get the time_slot value, als er geen is dan is het een lege string
            $timeSlotValue = $timeSlot['time_slot'] ?? 'Bel voor een afspraak';
            // Now you can use $timeSlotValue in your view
            $this->timeSlots[] = $timeSlotValue;
            // sort the array
            sort($this->timeSlots);
        }
    }
    public function selectTimeSlot($time)
    {
        $this->selectedTimeSlots = null;
        $this->selectedTimeSlots[] = $time;
        $this->form->time = $time;
    }
    public function nextMonth()
    {
        $this->month++; // verhoog de maand met 1
        if ($this->month > 12) {
            $this->month = 1;
            $this->year++;
        }
        $this->monthArray = Agenda::getDaysOfMonth($this->month, $this->year);
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'reservaties',$this->month,$this->year );
    }

    public function prevMonth()
    {
        $this->month--; // verlaag de maand met 1
        if ($this->month < 1) {
            $this->month = 12;
            $this->year--;
        }
        $this->monthArray = Agenda::getDaysOfMonth($this->month, $this->year);
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'reservaties',$this->month,$this->year);
    }

    public function createOrUpdateReservation()
    {
        // Validate the input
        $this->validate();

        // Create or update the reservation
        $reservation = Reservation::updateOrCreate(
            [
                'date' => $this->newLineDate,
                'time_slot' => $this->newLineTimeSlot,
                'customer_email' => $this->newLineCustomerEmail,
            ],
            [
                'created_at' => Carbon::now()->format('Y-m-d'),
                'number_of_person' => $this->newLineNumberOfPerson,
                'comment' => $this->newLineComment,
                'customer_name' => $this->newLineCustomerName,
                'customer_phone_number' => $this->newLineCustomerPhoneNumber,
                'is_four_course' => $this->newLineIsFourCourse,
                'active' => true,
                'is_new' => $this->newLineIsNew,
            ]
        );

        $reservation_id = $reservation->id; // Get the ID of the reservation

        session([
            'reservation' => [
                'date' => $this->newLineDate,
                'time_slot' => $this->newLineTimeSlot,
                'number_of_person' => $this->newLineNumberOfPerson,
                'comment' => $this->newLineComment,
                'customer_name' => $this->newLineCustomerName,
                'customer_phone_number' => $this->newLineCustomerPhoneNumber,
                'customer_email' => $this->newLineCustomerEmail,
                'is_four_course' => $this->newLineIsFourCourse,
                'quantity' => $this->newLineQuantity,
            ]
        ]);

        // Find the menus based on the same month logic
        $menus = Menu::whereMonth('date', Carbon::parse($this->newLineDate)->month)
            ->whereYear('date', Carbon::parse($this->newLineDate)->year)
            ->get();

        // Separate the menus into veggie and non-veggie
        $veggieMenu = $menus->where('is_veggie', true)->first();
        $nonVeggieMenu = $menus->where('is_veggie', false)->first();

        // Create or update the reservation_menu for veggie menu if exists
        if ($veggieMenu) {
            $veggieMenuId = $veggieMenu->id;
            Reservation_menu::updateOrCreate(
                [
                    'reservation_id' => $reservation_id,
                    'menu_id' => $veggieMenuId,
                ],
                [
                    'quantity' => $this->newLineQuantity,
                ]
            );
        }

        // Calculate the non-veggie quantity
        $nonVeggieQuantity = $this->newLineNumberOfPerson - $this->newLineQuantity;

        // Create or update the reservation_menu for non-veggie menu if exists and quantity is more than 0
        if ($nonVeggieMenu && $nonVeggieQuantity > 0) {
            $nonVeggieMenuId = $nonVeggieMenu->id;
            Reservation_menu::updateOrCreate(
                [
                    'reservation_id' => $reservation_id,
                    'menu_id' => $nonVeggieMenuId,
                ],
                [
                    'quantity' => $nonVeggieQuantity,
                ]
            );
        }

        // Redirect to the home page
        return redirect()->route('reservation.confirmation');
    }

    #[Layout('layouts.huiskamer', [
        'title' => 'Reserveren - Huiskamerrestaurant',
        'subtitle' => 'Reserveer een plekje in mijn huiskamerrestaurant',
        'description' => 'Hier kan u een reservatie maken. Indien dit niet lukt, aarzel niet om ons telefonisch te contacteren.'
    ])]
    public function render()
    {
        $regular_opening_hours = Agenda::regularOpeningHours()->get();
        $openingDays = Agenda::getRegularOpeningDays();
        $exceptional_opening_hours = Agenda::whereNotNull('date_exception')->get();
        $reservations_all = Reservation::getAllReservations();

        $selectedTimes = [];
        $timeSlots = [];
        $selectedDay = null;
        $selectedTime = null;
        $selectedTimeSlots = [];

        return view('livewire.reserveren', compact('reservations_all', 'regular_opening_hours','openingDays','exceptional_opening_hours','selectedTimes','timeSlots','selectedDay','selectedTime','selectedTimeSlots'  ));;
    }
}

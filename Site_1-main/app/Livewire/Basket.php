<?php

namespace App\Livewire;

use App\Helpers\Cart;
use App\Livewire\Forms\CookieForm;
use App\Models\Cookie;
use App\Models\Cookie_order_line;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Agenda;
use App\Models\Cookie_order;

class Basket extends Component


{

    public $selectedMonth;
    public $selectedDay = null;
    public $selectedDayd     = 32;
    public $selectedTime = null;
    public $selectedTimeSlots = [];
    public $timeSlots = [];
    public $backorder = [];
    public $showModal = false; // aanpassen naar false na testen
    public CookieForm $form;


    public $monthArray;

    // maand en jaar van de agenda

    public $month;
    public $year;
    public $openDaysOfMonth;
    public $filteredOpeningDays = [];
    public $uniqueMonths = [];
    public  $selectedDates = [];
   public  $selectedTimes = [];
    public $order;



    public $openingDays;




    public function mount()
    {
        // Haal de openingstijden op van de Agenda
        $openingDays = Agenda::getRegularOpeningDays('koekjes',90);

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
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'koekjes' );
    }

    // een functie die de dag omzet naar YY-m-d formaat
    public function selectDay($day)
    {
        $year = $this->year;
        $month = $this->month;
        $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');
        $this->form->date = $date;

    }

    // een functie die in $openingsDays zoekt naar de geselecteerde dag en de tijden van die dag teruggeeft
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
        $this->form->date = $date;
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
    $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'koekjes',$this->month,$this->year );
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
        $this->openDaysOfMonth = Agenda::findOpenDaysOfMonth($this->openingDays, 'koekjes',$this->month,$this->year);
    }


    public function checkoutForm()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
        $this->selectedTimes = [];
        $this->timeSlots = [];
        $this->selectedDay = null;
        $this->selectedTime = null;
        $this->selectedTimeSlots = [];

        // for debugging only

    }

    public function checkout()
    {
        // validate the form
        $this->form->validate();
        // hide the modal
        $this->showModal = false;
        // check if there are records in backorder
        $this->updateBackorder();

        // add the order to the database
        // create a new order

        $order = Cookie_order::create([
            'date_pick_up' => $this->form->date,
            'time_slot' => $this->form->time,
            'comment' => $this->form->notes,
            'customer_name' => $this->form->name,
            'customer_phone_number' => $this->form->phoneNumber,
            'customer_email' => $this->form->email,
            'active' => '1',
            'total_price' => Cart::getTotalPrice(),
            'is_new' => '1',
        ]);


        // loop over the cookies in the basket and add them to the orderlines table
        foreach (Cart::getCookies() as $cookie) {
            Cookie_order_line::create([
                'cookie_order_id' => $order->id,
                'cookie_id' => $cookie['id'],
                'number_of_packs' => $cookie['qty'],
                'price' => $cookie['price'],

            ]);
            // update the stock
            $updateQty = Cookie::findOrFail($cookie['id']);
            $updateQty->stock > $cookie['qty'] ? $updateQty->stock -= $cookie['qty'] : $updateQty->stock = 0;
            $updateQty->save();
        }
        // send confirmation email to the user

        $this->form->sendEmail($this->backorder);

        // reset the form, backorder array and error bag
        $this->form->reset();
        $this->reset('backorder');
        $this->resetErrorBag();
        // empty the cart
        Cart::empty();
        $this->dispatch('basketUpdated');
        // show a confirmation message
        $this->dispatch('swal:confirm', [
            'icon' => 'success',
            'background' => 'success',
            'html' => "Bedankt voor je bestelling.<br>De koekjes zullen klaarstaan op de dag van uw voorkeur.",
            'showConfirmButton' => false,
            'showCancelButton' => false,
        ]);
    }

    public function emptyBasket()
    {
        Cart::empty();
        $this->dispatch('basketUpdated');
    }

    public function decreaseQty(Cookie $cookie)
    {
        Cart::delete($cookie);
        $this->dispatch('basketUpdated');
    }

    public function increaseQty(Cookie $cookie)
    {
        Cart::add($cookie);
        $this->dispatch('basketUpdated');
    }

    public function updateBackorder()
    {
        $this->backorder = [];
        // loop over cookies in basket and check if qty > in stock

        foreach (Cart::getKeys() as $id) {
            $qty = Cart::getOneCookie($id)['qty'];


            $cookie = Cookie::findOrFail($id);

            $stock = $cookie->stock;
            $shortage = $qty - $stock;
            if ($shortage > 0)
//                $this->backorder[] = $shortage . ' x ' . $cookie->name;
                $this ->backorder[] = $shortage . ' x ' . $cookie->name . ' (slechts ' . $stock . ' in voorraad)';

        }
    }

    #[On('basketUpdated')]
    #[Layout('layouts.huiskamer', [
        'title' => 'Winkelmandje',
        'subtitle' => 'Winkelmandje',
/*        'description' => 'Dit is het winkelmandje'*/
    ])]
    public function render()
    {

        $this->updateBackorder();

        if ($this->form->date ) {
            $this->form->date = date('d-m-Y', strtotime($this->form->date));
        }

        if ($this->selectedDay) {
            $this->selectedDay = date('d-m-Y', strtotime($this->selectedDay));
        }

        return view('livewire.basket');
    }

}

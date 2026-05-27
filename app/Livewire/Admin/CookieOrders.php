<?php

namespace App\Livewire\Admin;

use App\Models\Cookie_order;

// Aanpassen!

use DateTime;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;


class CookieOrders extends Component  // (app livewire admin ....) // Aanpassen!
{
    // sjabloon voor de tabel CRUD --------------------------------------
    // Cookie_orders/cruds vervangen door ...s/...  en Cookie_order/crud door .../...
    public $orderBy = 'date_pick_up';
    public $orderAsc = true;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;

    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at']; // Attributes to exclude
    public $textareaColumns = ['comment']; // kolommen waarvoor textarea moet genomen worden ipv text

    public $booleanColumns = ['active', 'is_new']; // kolommen waarvoor checkbox moet genomen worden ipv text

    public $editing = false;
    public $editingLineId;
    public $perPage = 5;

    public $showModal = false;


    // filter and pagination
    use WithPagination;




    // toggle show modal
    public function toggleShowModal()
    {
        $this->showModal = !$this->showModal;
        // mount opnieuw
//        $this->mount();
    }

    public function openModal()
    {
        $this->resetValues();
        $this->showModal = true;
    }


    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }


// variabelen aanpassen!
    public $newLine,
        $newLineComment,
        $newLineDate_pick_up,
        $newLineCustomer_name,
        $newLineCustomer_email,
        $newLineCustomer_phone_number; // Aanpassen!

// validatie regels

// Booleans opsommen en naar 0 zetten

    public $newLineActive = 1;  //laten staan


    public $newLineIs_new = 1;  //laten staan


// validaties voor verplichte velden (buiten name)

    #[Validate('required|min:3|max:300', // Aanpassen!
        attribute: 'tijdslot' // Aanpassen!
    )]
    public $newLineTime_slot = ''; // Aanpassen!

// validaties voor numerieke velden
    #[Validate('nullable|numeric')]
    public $newLineTotal_price;

    // uitzondering op de unique rule bij edit (wanneer name niet bestaat, newLIneXxx aanpassen)
    public function rules()
    {
        return [
            'newLineDate_pick_up' => "required|min:3|max:30|unique:cruds,name,{$this->editingLineId}", // Aanpassen!
        ];
    }

    // $validationAttributes is used to replace the attribute name in the error message  (weergave voor errormessages)
    protected $validationAttributes = [
        'newLine' => 'name',
        'newLinePrice' => 'Prijs',
    ];


    public function toggleActive(Cookie_order $cookieOrder)
    {

        \Log::info('Toggling active status for Cookie_order ID: ' . $cookieOrder->id);
        \Log::info('Current active status: ' . $cookieOrder->active);

        $cookieOrder->update([
            'active' => !$cookieOrder->active
        ]);

        // Refresh the model to get the updated status from the database
        $cookieOrder->refresh();

        \Log::info('New active status: ' . $cookieOrder->active);
    }



    public function editLine($id) // Aanpassen!
    {
        $this->showModal = true;
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Cookie_order::findOrFail($id);
        $date = DateTime::createFromFormat('d-m-Y', $line->date_pick_up);
        $this->newLineDate_pick_up = $date->format('Y-m-d');
        $this->newLineTime_slot = $line->time_slot;
        $this->newLineTotal_price = $line->total_price;
        $this->newLineComment = $line->comment;
        $this->newLineCustomer_name = $line->customer_name;
        $this->newLineCustomer_email = $line->customer_email;
        $this->newLineCustomer_phone_number = $line->customer_phone_number;
        $this->newLineActive = $line->active;
        $this->newLineIs_new = $line->is_new;
    }

    public function createOrUpdate()
    {
//        $this->validateOnly('newLine');
//        $this->validateOnly('newLineDescription');
        $this->validate();

        $data = [                                                                       // Aanpassen!
            'date_pick_up' => $this->newLineDate_pick_up,
            'time_slot' => $this->newLineTime_slot,
            'total_price' => $this->newLineTotal_price,
            'comment' => $this->newLineComment,
            'customer_name' => $this->newLineCustomer_name,
            'customer_email' => $this->newLineCustomer_email,
            'customer_phone_number' => $this->newLineCustomer_phone_number,
            'active' => $this->newLineActive,
            'is_new' => $this->newLineIs_new,

        ];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Cookie_order::findOrFail($this->editingLineId);
            $line->update($data);

// swal toast weergeven, name aanpassen naar id wannneer name niet bestaat

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "Bestelling van <b><i>" . ucfirst($line->customer_name) . "</i></b> is aangepast",
            ]);
        } else {
            // Create a new record in create mode
            $newLine = Cookie_order::create($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($newLine->customer_name) . "</i></b> is toegevoegd",
            ]);
        }

        $this->resetValues();
        $this->mount();
    }

    // reset all the values and error messages
    public function resetValues() // Aanpassen!
    {
        $this->reset('newLine');
        $this->reset('newLineDate_pick_up');
        $this->reset('newLineTime_slot');
        $this->reset('newLineTotal_price');
        $this->reset('newLineComment');
        $this->reset('newLineCustomer_name');
        $this->reset('newLineCustomer_email');
        $this->reset('newLineCustomer_phone_number');
        $this->reset('newLineActive');
        $this->reset('showActive');
        $this->reset('newLineIs_new');
        $this->reset('showNotNew');
//        $this->reset('showToday');
        $this->reset('showModal');
        $this->reset('editingLineId');
        $this->reset('newCount');



        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
    }

    // reset the paginator after filtering
    public function updated($propertyName, $propertyValue)
    {
        // reset if the $search, ... property has changed (updated)
        if (in_array($propertyName, ['search', 'showActive', 'showNotNew' ,'showToday','perPage']))
            $this->resetPage();
    }


    // delete a order with java script
    #[On('delete-line')]
    public function delete($id)
    {
        $line = Cookie_order::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        // mount opnieuw
        $this->mount();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Bestelling van <b><i>" . ucfirst($line->customer_name) . "</i></b> is verwijderd",
        ]);
    }

    public $showNotNew = false;
    public $showActive = false;
    public $showToday = false;
    public $newCount = 0;
    public $todayCount;
    public $activeCount;
    public $notPickUpCount;

    protected $queryString = ['showToday'];


    public function mount()
    {
        $showToday = request()->input('showToday');

//        // Tel hoeveel er vandaag moeten opgehaald worden
//        $this->todayCount = Cookie_order::whereDate('date_pick_up', now()->toDateString())
//            ->where('active', true)
//            ->count();

        // Tel hoeveel is_new true zijn
        $this->newCount = Cookie_order::where('is_new', true)->count();

//        // Tel hoeveel er actief zijn
//        $this->activeCount = Cookie_order::where('active', true)->count();

        // Controleer of $showToday is ingesteld via de query parameter
//        dump($showToday); // Log de query parameter $showToday
        if ($showToday !== null) {
            // Als $showToday is ingesteld, gebruik die waarde
            $this->showToday = filter_var($showToday, FILTER_VALIDATE_BOOLEAN);
        } else {
            // Als $showToday niet is ingesteld, bepaal de waarde op basis van het aantal bestellingen voor vandaag
            // afhalingen vandaag
            if ($this->todayCount > 0) {
                $this->showToday = true;
                $this->showActive = false;
                $this->showNotNew = true;
            } else {
                $this->showToday = false;
                if ($this->newCount > 0) {
                    $this->showNotNew = false;
                } else {
                    $this->showNotNew = true;
                }
            }
        }
    }



    // Functie die alle cookieorders met een waarde van is_new = true ophaalt en op false zet
    public function resetIsNew()
    {
        $lines = Cookie_order::where('is_new', true)->get();
        foreach ($lines as $line) {
            $line->update([
                'is_new' => false
            ]);
        }
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Alle nieuwe bestellingen zijn verwerkt",
            'timer' => 3000,
            'timerProgressBar' => true,
        ]);

//        $this->reset('newCount');
//        $this -> showNotNew = true;
        return redirect()->to(route('admin.koekjesbestellingen'));
    }

    // Functie die showNotNew op false zet
    public function toggleShowNotNew()
    {
        if ($this->newCount > 0) {
            $this->showNotNew = !$this->showNotNew;
        }
    }


    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    #[Layout('layouts.huiskamer', ['title' => 'Koekjesbestellingen', 'Koekjesbestellingen' => 'Koekjesbestellingen'])]
    public function render()
    {
        $query = Cookie_order::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->searchColumns($this->search);


        // Determine the columns based on include/exclude attributes
        $firstLine = $query->first();
        if ($firstLine) {
            $attributes = array_keys($query->first()->getAttributes());
            $this->columns = array_merge($this->includeAttributes, array_diff($attributes, $this->excludeAttributes));
        } else {
            $this->columns = [];
        }

        // Tel hoeveel er actief zijn
        $this->activeCount = Cookie_order::where('active', true)->count();

        // Apply the scope for the filter
        if ($this->showActive) {
            $query->where('active', false);
        } else {
            $query->where('active', true);
        }

        if ($this->showNotNew) {
        /*    $query->where('is_new', false);*/
        } else {
            $query->where('is_new', true);
        }

        if ($this->showToday) {
            $query->whereDate('date_pick_up', now()->toDateString());
        }


        // Paginate the results after applying the scope
        $lines = $query->paginate($this->perPage);

        // Loop through each cookie order and retrieve related cookies
        foreach ($lines as $line) {
            $line->cookies = $line->getCookies();
        }

        // Tel hoeveel er vandaag moeten opgehaald worden
        $this->todayCount = Cookie_order::whereDate('date_pick_up', now()->toDateString())
            ->where('active', true)
            ->count();

        // Tel onopgehaalde bestellingen
        $this->notPickUpCount = Cookie_order::where('active', true)
            ->whereDate('date_pick_up', '<', now()->toDateString())
            ->count();

        return view('livewire.admin.cookie-orders', compact('lines'));
    }


}

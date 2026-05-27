<?php

namespace App\Livewire;

use App\Helpers\Cart;
use App\Models\Cookie;
use App\Models\Template_webpage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Koekjes extends Component
{
    // use WithPagination;
    use withPagination;

    // public properties
    public $perPage = 6;
    public $loading = 'Please wait...';


    // sort properties
    public $orderBy = 'name';
    public $orderAsc = true;

    // reset all the values and error messages
    public function resetValues()
    {
//        // reset all the errorvalues
        $this->resetErrorBag();
    }

    // public function to reset the filter and the pagination
    public function updated($property, $value)
    {
        // $property: The name of the current property being updated
        // $value: The value about to be set to the property
        if (in_array($property, ['perPage', 'name',  'price', 'orderBy', 'orderAsc']))
            $this->resetPage();
    }

    // properties for the modal
    public $selectedCookie;

    public $showModal = false;


    // properties for the cookies detail modal
    public function showItemDetails(Cookie $cookie)
    {
        $this->selectedCookie = $cookie;
        $this->showModal = true;

    }
    public function addToBasket(Cookie $cookie)
    {
        Cart::add($cookie);
        $this->dispatch('basketUpdated');
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>{$cookie->name}</i></b> zijn toegevoegd aan het winkelmandje",
            'position' => 'top-start',
            'icon' => 'success',
        ]);
    }

    #[Layout('layouts.huiskamer', [
        'title' => 'Koekjes',
//        'subtitle' => 'Overzicht koekjes',
        'description' => 'Onze overheerlijke koekjes'
    ])]
    public function render()
    {

        $cookies = Cookie::orderBy($this->orderBy, $this->orderAsc  ? 'asc' : 'desc')
                ->paginate($this->perPage);
        $cookieText = Template_webpage::where('type', 'cookie')->first();


        return view('livewire.koekjes', compact('cookies', 'cookieText'));
    }



}

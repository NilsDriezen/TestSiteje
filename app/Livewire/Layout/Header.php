<?php

namespace App\Livewire\Layout;

use App\Models\Cookie_order;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;



class Header extends Component
{

    #[On('basketUpdated')]
    public function render()
    {

        // Haal het aantal orders op waar is_new = true
        $aantal = Cookie_order::where('is_new', true)->count();

        // Haal het aantal reservaties op waar is_new = true
        $aantalreservaties = DB::table('reservations')->where('is_new', true)->count();

        // Haal het aantal reviews op waar is_new = true
        $aantalNieuweReviews = Review::where('is_new', true)->count();

        // Haal het aantal orders op waar is_new = true
        $aantal = Cookie_order::where('is_new', true)->count();
        return view('livewire.layout.header', [
            'aantal' => $aantal,
            'aantalreservaties' => $aantalreservaties,
            'aantalNieuweReviews' => $aantalNieuweReviews
        ]);
    }
}

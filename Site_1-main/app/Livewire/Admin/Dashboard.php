<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Cookie_order;
use App\Livewire\Admin\CookieOrders;
use App\Models\Reservation;
use App\Models\Review;
//

class Dashboard extends Component
{

    #[Layout('layouts.huiskamer', [
        'title' => 'Dashboard',
        'subtitle' => 'Dashboard',
        'description' => 'Dashboard',
    ])]
    public function render()
    {

        // Haal het aantal orders op waar is_new = true
        $aantal = Cookie_order::where('is_new', true)->count();

        // Haal het aantal reservaties op waar is_new = true
        $aantalreservaties = DB::table('reservations')->where('is_new', true)->count();

        // Haal het aantal reviews op waar is_new = true
        $aantalNieuweReviews = Review::where('is_new', true)->count();


        // Return the view with both counts
        return view('livewire.admin.dashboard', [
            'aantal' => $aantal,
            'aantalreservaties' => $aantalreservaties,
            'aantalNieuweReviews' => $aantalNieuweReviews
        ]);
    }








}

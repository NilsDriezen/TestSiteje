<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\Cookie_order;
use Carbon\Carbon;

class Planning extends Component
{
    public $orderByReservation = 'id';
    public $orderAscReservation = true;
    public $orderByCookie = 'id';
    public $orderAscCookie = true;

    public $excludeCookie = ['id', 'active', 'total_price', 'is_new', 'created_at', 'updated_at', 'customer_email'];
    public $excludeReservation = ['id', 'active', 'is_new', 'created_at', 'updated_at', 'customer_email'];
    public $reservationColumns = ['number_of_person', 'date', 'time_slot', 'comment', 'customer_name', 'customer_phone_number', 'customer_email', 'active', 'is_four_course', 'is_new'];
    public $cookieColumns = ['date_pick_up', 'active', 'time_slot', 'customer_name', 'customer_phone_number', 'customer_email', 'comment', 'total_price', 'is_new'];


    #[Layout('layouts.huiskamer', [
        'title' => 'Planning',
        'subtitle' => 'Welkom op de planning pagina!',
        'description' => 'Hieronder vindt u een overzicht van alle reserveringen en cookie bestellingen voor vandaag en morgen.',
    ])]
    public function render()
    {
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();

        $reservations = Reservation::whereDate('date', $today)
            ->orWhereDate('date', $tomorrow)
            ->orderBy('date', 'asc')
            ->orderBy('time_slot', 'asc')
            ->get();

        $cookieOrders = Cookie_order::whereDate('date_pick_up', $today)
            ->orWhereDate('date_pick_up', $tomorrow)
            ->orderBy('date_pick_up', 'asc')
            ->orderBy('time_slot', 'asc')
            ->get();

        return view('livewire.user.planning', [
            'reservations' => $reservations,
            'cookieOrders' => $cookieOrders,
        ]);
    }}

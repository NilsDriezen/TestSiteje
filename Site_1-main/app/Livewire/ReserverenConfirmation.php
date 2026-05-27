<?php

namespace App\Livewire;

use Livewire\Component;

class ReserverenConfirmation extends Component
{
    public $reservation;

    public function mount()
    {
        $this->reservation = session('reservation', []);
    }

    public function render()
    {
        return view('livewire.reserveren-confirmation', [
            'reservation' => $this->reservation,
        ])->layout('layouts.huiskamer', [
            'title' => 'Bevestiging - Huiskamerrestaurant',
            'subtitle' => 'Bevestiging van uw reservering',
            'description' => 'Hartelijk dank voor het plaatsen van uw reservering.',
        ]);
    }
}

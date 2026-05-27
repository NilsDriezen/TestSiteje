<?php

namespace App\Livewire\User;

use App\Models\Cookie_order;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('layouts.huiskamer', [
        'title' => 'Dashboard',
        'subtitle' => 'Dashboard',
        'description' => 'Dashboard',
    ])]
    public function render()
    {
        // Tel hoeveel er vandaag moeten opgehaald worden
        $todayCount = Cookie_order::whereDate('date_pick_up', now()->toDateString())
            ->where('active', true)
            ->count();
        return view('livewire.user.dashboard', compact('todayCount'));
    }
}

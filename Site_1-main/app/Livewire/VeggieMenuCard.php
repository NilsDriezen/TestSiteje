<?php

namespace App\Livewire;

use App\Models\Menu;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class VeggieMenuCard extends Component
{
    public $date;

    public function render()
    {
        $thisMonthVeggieMenu = Menu::whereMonth('date', Carbon::now()->month)
//            ->whereYear('date', Carbon::now()->year)
            ->where('is_veggie', 1)
            ->get();
        return view('livewire.veggie-menu-card', compact('thisMonthVeggieMenu'));
    }
}

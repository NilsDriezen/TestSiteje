<?php

namespace App\Livewire;

use App\Models\Menu;
use Carbon\Carbon;
use Livewire\Component;

class VeggieMenuCardNm extends Component
{
    public function render()
    {
        $nextMonthVeggieMenu = Menu::whereMonth('date', Carbon::now()->addMonth()->month)
//            ->whereYear('date', Carbon::now()->year)
            ->where('is_veggie', 1)
            ->get();
        return view('livewire.veggie-menu-card-nm', compact('nextMonthVeggieMenu'));
    }
}

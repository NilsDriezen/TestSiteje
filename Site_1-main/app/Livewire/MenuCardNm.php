<?php

namespace App\Livewire;

use App\Models\Menu;
use Carbon\Carbon;
use Livewire\Component;

class MenuCardNm extends Component
{
    public function render()
    {
        $nextMonthMenu = Menu::whereMonth('date', Carbon::now()->addMonth()->month)
            ->where('is_veggie', 0)
            ->get();
        return view('livewire.menu-card-nm', compact('nextMonthMenu'));
    }
}

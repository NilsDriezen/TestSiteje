<?php

namespace App\Livewire;

use App\Models\Menu;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class MenuCard extends Component
{
    public $date;

    public function render()
    {
        $thisMonthMenu = Menu::whereMonth('date', Carbon::now()->month)
            ->where('is_veggie', 0)
            ->get();
        return view('livewire.menu-card', compact('thisMonthMenu'));
    }
}

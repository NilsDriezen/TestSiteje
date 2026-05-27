<?php

namespace App\Livewire;

use App\Models\Template_webpage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Menu extends Component
{
    #[Layout('layouts.huiskamer', [
        'title' => 'Menu',
        'subtitle' => 'Menu',
        'description' => 'Culinaire Verwennerij: Maandelijks Menu met Vegetarische Opties.'
    ])]
    public function render()
    {
        $menuTemplate = Template_webpage::where('type', 'menu')->first();
        $currentMonth = date('F');
        $nextMonth = date('F', strtotime('+1 month'));
        return view('livewire.menu', compact('currentMonth', 'nextMonth', 'menuTemplate'));
    }
}

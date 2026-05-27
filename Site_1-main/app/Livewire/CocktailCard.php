<?php

namespace App\Livewire;

use App\Models\Cocktail;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CocktailCard extends Component
{
    public $date;
    public function render()
    {
        $thisMonthCocktail = Cocktail::whereMonth('date', Carbon::now()->month)
            ->get();
        return view('livewire.cocktail-card', compact('thisMonthCocktail'));
    }
}

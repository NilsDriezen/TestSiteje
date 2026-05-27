<?php

namespace App\Livewire;

use App\Models\Cocktail;
use Carbon\Carbon;
use Livewire\Component;

class CocktailCardNm extends Component
{
    public function render()
    {
        $nextMonthCocktail = Cocktail::whereMonth('date', Carbon::now()->addMonth()->month)
            ->get();
        return view('livewire.cocktail-card-nm', compact('nextMonthCocktail'));
    }
}


<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class UnderConstruction extends Component
{
    #[Layout('layouts.huiskamer', [
        'title' => 'Under Construction',
        'subtitle' => 'This is the under construction page',
        'description' => 'This is the under construction page'
    ])]
    public function render()
    {
        return view('livewire.under-construction');
    }
}

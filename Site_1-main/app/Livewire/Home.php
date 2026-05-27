<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Template_webpage;
use App\Models\Review;
use Livewire\Attributes\Validate;

class Home extends Component
{
    #[Validate('required_unless:isAnonymous,true|min:3|max:20', // Aanpassen!
        attribute: 'Naam' // Aanpassen!
    )] public $newLineName;
    #[Validate('required|min:3|max:255', // Aanpassen!
        attribute: 'Bericht' // Aanpassen!
    )]public $newLineMessage;
    public $isAnonymous = false;



    public function messages()
    {
        return [
            'newLineName' => 'Naam is verplicht.',
            'newLineMessage' => 'Bericht is verplicht',
        ];
    }


    public function createOrUpdate()
    {
        $this->validate([
            'newLineName' => 'required_unless:isAnonymous,true|max:20',
            'newLineMessage' => 'required|min:3|max:255',
        ]);

        $name = $this->isAnonymous ? 'Anoniem' : $this->newLineName;

        // Create a new review
        Review::create([
            'name' => $name,
            'message' => $this->newLineMessage,
            'is_approved' => false, // Set the is_approved field to false by default
            'is_new' => true // Set the is_new field to true by default
        ]);

        // Flash a success message to the session
        session()->flash('toast', [
            'type' => 'success',
            'message' => 'Bedankt voor uw Review!\nUw review wordt toegevoegd na controle van de eigenaar.' // toast berichtje
        ]);

        // Reset the form fields
        $this->resetValues();

        // Redirect to the home page
        return redirect()->route('home');
    }


    public function resetValues()
    {
        $this->newLineName = '';
        $this->newLineMessage = '';
    }
    #[Layout('layouts.huiskamer', [
        'title' => 'Home',
        'subtitle' => 'Huiskamer',
        'description' => 'Culinaire reis door de wereld van smaak.',
    ])]
    public function render()
    {
        $template_webpage = Template_webpage::where('type', 'home')->first();
        $reviews = Review::where('is_approved', true)->get();

        return view('livewire.home', compact('template_webpage', 'reviews'));
    }
}

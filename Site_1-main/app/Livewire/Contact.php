<?php

namespace App\Livewire;

use App\Models\Agenda;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Template_webpage;



class Contact extends Component
{
    public $template_webpage;

    #[Layout('layouts.huiskamer', [
        'title' => 'Contact',
        'subtitle' => 'Contact info',
        'description' => 'Heb je nog vragen? Neem gerust contact met ons op.'
    ])]
    public function render()
    {
        $template_webpage = $this->template_webpage = Template_webpage::where('type', 'contact')->first();
        // haal van agenda de dagen op waar date_exception null is en type reservering is, ik wil de kolommen day_of_week, time_start en time_end

        $dagen = Agenda::where('date_exception', null)
        ->where('type', 'reservaties')
        ->orderByRaw('FIELD(day_of_week, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday") ' . 'ASC')
            ->orderBy('time_start', 'ASC')
        ->get(['day_of_week', 'time_start', 'time_end'])
        ->groupBy('day_of_week');

        $speciale_dagen = Agenda::where('date_exception', '!=', null)
        ->where('type', 'reservaties')
            // en later dan vandag
            ->where('date_exception', '>=', date('Y-m-d'))
            // en closed is 0
            ->where('closed', 0)
        ->orderBy('date_exception', 'ASC')
        ->get(['date_exception', 'time_start', 'time_end'])
        ->groupBy('date_exception');




        return view('livewire.contact', compact('template_webpage', 'dagen' ,'speciale_dagen'));
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Cookie;
use App\Models\Dish;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

// Aanpassen!


class Koekjesbeheer extends Component
{
    // sjabloon voor de tabel CRUD --------------------------------------

    public  $orderBy = 'id' ;
    public  $orderAsc = true ;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at' ]; // Attributes to exclude
    public $textareaColumns = ['description']; // kolommen waarvoor textarea moet genomen worden ipv text
    public $booleanColumns = ['active']; // kolommen waarvoor checkbox moet genomen worden ipv text
    public $hiddenColumns = ['id', 'picture_path','dish_id']; // kolommen die niet getoond worden

    public $editing = false;
    public $editingLineId;
    public $perPage = 5;

    public $showModal = false;
    public $showActive = false;
public $showInStock = false;

    protected $queryString = ['search'];
    /**
     * @var mixed|null
     */


    use WithPagination;

    public function mount($id = null)
    {

        if ($id) {
            $cookie = Cookie::find($id);
            $this->editLine($id);
        }

    }


    public function toggleActive(Cookie $id)
    {
//        dump($id);
        $id->update([
            'active' => !$id->active
        ]);
    }

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    // validatie regels
    public $newLine = '', $newLinePicture_path, $newLineDish_id = 1; // Aanpassen!


    #[Validate('required|min:3|max:300', // Aanpassen!
        attribute: 'Beschrijving' // Aanpassen!
    )]
    public $newLineDescription = '';

    #[Validate('required|numeric')]
    public $newLinePrice = '';
    #[Validate('required|numeric')]
    public $newLineStock = '';

    #[validate('boolean')]
    public $newLineActive = 1;


    // uitzondering op de unique rule bij edit
    public function rules()
    {
        return [
            'newLine' => "required|min:3|max:30|unique:cruds,name,{$this->editingLineId}", // Aanpassen!
        ];
    }

    // toggle show modal
    public function toggleShowModal()
    {
        $this->showModal = !$this->showModal;
    }

     public function openModal()
    {
        $this->resetValues();
        $this->showModal = true;
    }

    // $validationAttributes is used to replace the attribute name in the error message
    protected $validationAttributes = [
        'newLine' => 'naam',
        'newLinePrice' => 'prijs',
        'newLineDescription' => 'beschrijving',
        'newLinePicture_path' => 'afbeeldingspad',
        'newLineStock' => 'beschikbaarheid',
        'newLineDish_id' => 'gerecht id',
    ];

    public function editLine($id)
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Cookie::findOrFail($id);

        $this->newLine = $line->name;
        $this->newLineDescription = $line->description;
        $this->newLinePrice = $line->price;
        $this->newLinePicture_path = $line->picture_path;
        $this->newLineStock = $line->stock;
        $this->newLineActive = $line->active;
        $this->newLineDish_id = $line->dish_id;
        $this->showModal = true;
    }




    public function createOrUpdate()
    {
        $this->validate();
        $data = [                                                                       // Aanpassen!
            'name' => $this->newLine,
            'description' => $this->newLineDescription,
            'price' => $this->newLinePrice,
            'picture_path' => $this->newLinePicture_path,
            'stock' => $this->newLineStock,
            'active' => $this->newLineActive,
            'dish_id' => $this->newLineDish_id,
        ];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Cookie::findOrFail($this->editingLineId);
            $line->update($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is bijgewerkt",
            ]);
        } else {
            // Create a new record in create mode
            $newLine = Cookie::create($data);

// Verkrijg de ID van de nieuw gemaakte cookie
            $newCookieId = $newLine->id;

// Stel picture_path in op cookie_id.jpg
            $data['picture_path'] = 'cookie_'. $newCookieId . '.jpg';

// Update de cookie met de juiste picture_path
            $newLine->update($data);

//            $this->dispatch('swal:toast', [
//                'background' => 'success',
//                'html' => "<b><i>" . ucfirst($newLine->name) . "</i></b> is toegevoegd",
//
//            ]);

            // Vraag of de gebruiker een foto wil toevoegen en redirect al dan niet naargelang het antwoord
            $this->dispatch('swal:confirm', [
                'title' => 'Foto toevoegen',
                'text' => 'Wil je een foto toevoegen aan dit koekje?',
                'cancelButtonText' => 'Nee',
                'confirmButtonText' => 'Ja',

                'next' => [
                    'event' => 'addPicture',
                    'params' => ['newCookieId' => $newCookieId, 'name' => $newLine->name],
                ]

            ]);

            //redirect naar de pagina om de foto te uploaden met de ID van het nieuwe cookie als parameter en open de modal
//            return redirect()->route('admin.cookiepictures', $newCookieId);

        }
        $this->resetValues();
    }

    #[on('addPicture')]
    public function addPicture($newCookieId,$name = null)
    {
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($name) . "</i></b> is toegevoegd",
        ]);

       return redirect()->route('admin.cookiepictures', $newCookieId);
    }

    // reset all the values and error messages
    public function resetValues()
    {
        $this->reset('newLine');
        $this->reset('newLineDescription');
        $this->reset('newLinePrice');
        $this->reset('newLinePicture_path');
        $this->reset('newLineStock');
        $this->reset('newLineActive');
        $this->reset('newLineDish_id');
        $this->reset('editingLineId');
        $this->reset('showModal');
        $this->reset('showActive');
        $this->reset('showInStock');

        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
    }

    public function updated($propertyName, $propertyValue)
    {
        // reset if the $search, ... property has changed (updated)
        if (in_array($propertyName, ['search', 'showActive', 'showInStock','perPage']))
            $this->resetPage();
    }

    // delete a item with java script
    #[On('delete-line')]
    public function delete($id)
    {
        // ga na of er in de cookie_order_lines tabel een record bestaat met het te verwijderen koekje
        $cookieOrderLine = \App\Models\Cookie_order_line::where('cookie_id', $id)->first();
        // wanneer er geen is, verwijder het koekje, anders zend een melding


        if ($cookieOrderLine === null) {
            $line = Cookie::findOrFail($id);
            Cookie::destroy($id);
            $this->resetPage();
            $this->resetValues();

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'position' => 'top-end',
                'timer' => 3000,
                'timerProgressBar' => true,
                'toast' => true,
                'showConfirmButton' => false,
                'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is verwijderd",
            ]);
        } else {
            $this->dispatch('swal:toast', [
                'icon' => 'error',
                'position' => 'top-end',
                'timer' => 3000,
                'timerProgressBar' => true,
                'toast' => true,
                'background' => 'success',
                'title' => 'Koekje verwijderen',
                'text' => 'Dit koekje werd reeds besteld. Het zal enkel op non-actief gezet worden.',
                'params' => [
                    'id' => $id
                ]
            ]);
            // update het koekje met de active status op false
            $cookie = Cookie::find($id);
            $cookie->update([
                'active' => false
            ]);


        }








    }

    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    #[Layout('layouts.huiskamer', ['title' => 'Koekjesbeheer', 'description' => 'Welkom op de koekjesbeheer pagina. '])]
    public function render()
    {

        $query = Cookie::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->with('dish')
            ->searchColumns($this->search);

        // Apply the scope for the filter
        if ($this->showActive) {
            $query->where('active', false);
        } else {
            $query->where('active', true);
        }

        if ($this->showInStock) {
            $query->where('stock', '<', 1);
        } else {
            /*$query->where('stock', '>', 0);*/
        }

        // Determine the columns based on include/exclude attributes
        $firstLine = $query->first();
        if ($firstLine) {
            $attributes = array_keys($query->first()->getAttributes());
            $this->columns = array_merge($this->includeAttributes, array_diff($attributes, $this->excludeAttributes));
        } else {
            $this->columns = [];
        }



// Gerechten ophalen waarvan het bijbehorende Course van type 'koekje' is
        $dishes = Dish::whereHas('course', function ($query) {
            $query->where('type', 'koekje');
        })
            ->get()
            ->sortBy('name');





        // Paginate the results after applying the scope
        $lines = $query->paginate($this->perPage);

        return view('livewire.admin.koekjesbeheer', compact('lines', 'dishes'));
    }


}

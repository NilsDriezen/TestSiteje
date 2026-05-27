<?php

namespace App\Livewire\Admin;

use App\Models\Ingredient;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

// Aanpassen!


class Ingredienten extends Component
{
    // sjabloon voor de tabel CRUD --------------------------------------

    public  $orderBy = 'id' ;
    public  $orderAsc = true ;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at' ]; // Attributes to exclude
    public $textareaColumns = []; // kolommen waarvoor textarea moet genomen worden ipv text
    public $booleanColumns = []; // kolommen waarvoor checkbox moet genomen worden ipv text

    public $editing = false;
    public $editingLineId;
    public $perPage = 5;

    use WithPagination;

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    // validatie regels
    public $newLine; // Aanpassen!


    #[Validate('required|numeric')]
    public $newLinePrice = '';
    #[Validate('numeric')]
    public $newLineStock = '';

//    #[validate('boolean')]
    public $newLineActive = 0;


    // uitzondering op de unique rule bij edit
    public function rules()
    {
        return [
            'newLine' => "required|min:3|max:30|unique:cruds,name,{$this->editingLineId}", // Aanpassen!
        ];
    }

    // $validationAttributes is used to replace the attribute name in the error message
    protected $validationAttributes = [
        'newLine' => 'naam',
        'newLinePrice' => 'prijs',
    ];

    public function editLine($id)
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Ingredient::findOrFail($id);

        $this->newLine = $line->name;

        $this->newLinePrice = $line->price;

        $this->newLineActive = $line->active;
    }

    public function createOrUpdate()
    {
//        $this->validateOnly('newLine');
//        $this->validateOnly('newLineDescription');
        $this->validate();

        $data = [                                                                       // Aanpassen!
            'name' => $this->newLine,
            'price' => $this->newLinePrice,

        ];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Ingredient::findOrFail($this->editingLineId);
            $line->update($data);


            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->name) . "</i></b>  is aangepast",
            ]);
        } else {
            // Create a new record in create mode
            $newLine = Ingredient::create($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($newLine->name) . "</i></b>  is aangepast",
            ]);
        }

        $this->resetValues();
    }

    // reset all the values and error messages
    public function resetValues()
    {
        $this->reset('newLine');
        $this->reset('newLinePrice');
        $this->reset('newLineActive');


        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
    }

    public function updated($property, $value)
    {
        // $property: The name of the current property being updated
        // $value: The value about to be set to the property        if (in_array($property, ['perPage', 'search']))
        $this->resetPage();
    }


    // delete a item with java script
    #[On('delete-line')]

    public function delete($id)
    {
        $line = Ingredient::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is verwijderd",
        ]);
    }

    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    #[Layout('layouts.huiskamer', ['title' => 'Ingrediënten', 'description' => 'Welkom op de ingrediënten pagina. '])]
    public function render()
    {
        $query = Ingredient::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->searchColumns($this->search);

        // Determine the columns based on include/exclude attributes
        $firstLine = $query->first();
        if ($firstLine) {
            $attributes = array_keys($query->first()->getAttributes());
            $this->columns = array_merge($this->includeAttributes, array_diff($attributes, $this->excludeAttributes));
        } else {
            $this->columns = [];
        }

        // Paginate the results after applying the scope
        $lines = $query->paginate($this->perPage);

        return view('livewire.admin.ingredienten', compact('lines'));
    }


}

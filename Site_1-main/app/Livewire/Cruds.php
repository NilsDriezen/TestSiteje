<?php

namespace App\Livewire;

use App\Models\Crud; // Aanpassen!
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;



class Cruds extends Component
{
    // sjabloon voor de tabel CRUD --------------------------------------
    // Cruds/cruds vervangen door ...s/...  en Crud/crud door .../...

    public  $orderBy = 'id' ;
    public  $orderAsc = true ;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at' ]; // Attributes to exclude
    public $textareaColumns = ['description']; // kolommen waarvoor textarea moet genomen worden ipv text

    public $booleanColumns = []; // kolommen waarvoor checkbox moet genomen worden ipv text

    public $editing = false;
    public $editingLineId;
    public $perPage = 5;

    public $newLineActive = false;

    use WithPagination;

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    // validatie regels
    public $newLine, $newLineAddress, $newLineCity, $newLineZip, $newLineCountry; // Aanpassen!

    #[Validate('required|min:3|max:300', // Aanpassen!
        attribute: 'description' // Aanpassen!
    )]
    public $newLineDescription = '';
    #[Validate('nullable|numeric')]
    public $newLinePrice ;

    // uitzondering op de unique rule bij edit
    public function rules()
    {
        return [
            'newLine' => "required|min:3|max:30|unique:cruds,name,{$this->editingLineId}", // Aanpassen!
        ];
    }

    // $validationAttributes is used to replace the attribute name in the error message
    protected $validationAttributes = [
        'newLine' => 'name',
        'newLinePrice' => 'Prijs',
    ];

    public function editLine($id) // Aanpassen!
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Crud::findOrFail($id);

        $this->newLine = $line->name;
        $this->newLineDescription = $line->description;
        $this->newLinePrice = $line->price;
        $this->newLineAddress = $line->address;
        $this->newLineCity = $line->city;
        $this->newLineZip = $line->zip;
        $this->newLineCountry = $line->country;


    }

    public function createOrUpdate()
    {
//        $this->validateOnly('newLine');
//        $this->validateOnly('newLineDescription');
        $this->validate();

        $data = [                                                                       // Aanpassen!
            'name' => $this->newLine,
            'description' => $this->newLineDescription,
            'price' => $this->newLinePrice,
            'address' => $this->newLineAddress,
            'city' => $this->newLineCity,
            'zip' => $this->newLineZip,
            'country' => $this->newLineCountry,
            'active' => $this->newLineActive,

        ];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Crud::findOrFail($this->editingLineId);
            $line->update($data);


            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is aangepast",
            ]);
        } else {
            // Create a new record in create mode
            $newLine = Crud::create($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($newLine->name) . "</i></b> is toegevoegd",
            ]);
        }

        $this->resetValues();
    }

    // reset all the values and error messages
    public function resetValues() // Aanpassen!
    {
        $this->reset('newLine');
        $this->reset('newLineDescription');
        $this->reset('newLinePrice');
        $this->reset('newLineAddress');
        $this->reset('newLineCity');
        $this->reset('newLineZip');
        $this->reset('newLineCountry');
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


    // delete a line with java script
    #[On('delete-line')]

    public function delete($id)
    {
        $line = Crud::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is verwijderd",
        ]);
    }

    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    #[Layout('layouts.huiskamer', ['title' => 'Crud', 'description' => 'Template for CRUD operations.'])]
    public function render()
    {
        $query = Crud::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
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

        return view('livewire.cruds', compact('lines'));
    }


}

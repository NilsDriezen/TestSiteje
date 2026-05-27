<?php

namespace App\Livewire\Admin;

use App\Models\Review; // Aanpassen!
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;



class Reviews extends Component
{
    // sjabloon voor de tabel CRUD --------------------------------------
    // Cruds/cruds vervangen door ...s/...  en Crud/crud door .../...
    public  $orderBy = 'id' ;
    public  $orderAsc = false ; //aflopend zodat de nieuwe reviews bovenaan komen
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['updated_at', 'created_at' ]; // Attributes to exclude
    public $textareaColumns = ['']; // kolommen waarvoor textarea moet genomen worden ipv text

    public $booleanColumns = ['is_approved']; // kolommen waarvoor checkbox moet genomen worden ipv text

    public $editing = false;
    public $editingLineId;
    public $perPage = 20;
    public $newLineActive = false;  //laten staan
    public $newLineIs_approved = 0; //laten staan

    public $showModal = false;

    public $showOnlyPending = null; // Ensure it's defined as public

    #[Validate('required|min:3|max:20', as: "naam" )]
    public $newLine; // Aanpassen!

    #[Validate('required|min:3|max:255', // Aanpassen!
        attribute: 'Bericht' // Aanpassen!
    )] public $newLineMessage = '';


    use WithPagination;

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    public function rules()
    {
        return [
            'newLine' => "required|min:3|max:20|unique:name,{$this->editingLineId}", // Aanpassen!
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
        'newLine' => 'Naam',
        'newLineMessage' => 'Bericht',
    ];

    public function editLine($id) // Aanpassen!
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Review::findOrFail($id);

        $this->newLine = $line->name;
        $this->newLineIs_approved = $line->is_approved;
        $this->newLineMessage = $line->message;
        $this->showModal = true;


    }

    public function createOrUpdate()
    {
        $this->validate();



        $data = [                                                                       // Aanpassen!
            'name' => $this->newLine,
            'is_approved' => $this->newLineIs_approved,
            'message' => $this->newLineMessage,

        ];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Review::findOrFail($this->editingLineId);
            $line->update($data);


            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is aangepast",
            ]);
        } else {
            // Create a new record in create mode
            $newLine = Review::create($data);

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
          $this->reset('newLineIs_approved');
        $this->reset('newLineMessage');
        $this->reset('showModal');
        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
    }


    #[On('delete-line')]

    public function delete($id)
    {
        $line = Review::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($line->name) . "</i></b> is verwijderd",
        ]);
    }

    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    public function toggleActive(Review $id)
    {
//        dump($id);
        $id->update([
            'is_approved' => !$id->is_approved
        ]);
    }


    public function toggleShowOnlyPending()
    {
        if ($this->showOnlyPending === null) {
            $this->showOnlyPending = true; // If currently null, set to true
        } elseif ($this->showOnlyPending === true) {
            $this->showOnlyPending = false; // If currently true, set to false
        } else {
            $this->showOnlyPending = null; // If currently false, set to null
        }

        $this->orderAsc = true; // Reset order to ascending
        $this->orderBy = 'id'; // Reset order by id
        $this->resetPage(); // Reset pagination page
    }


    //schakel alle is_new waarden naar false
   public function toggleIsNew()
   {
       // Set all is_new values to false
       Review::query()->update(['is_new' => false]);

       // Refresh the Livewire component to reflect the changes
       $this->resetPage(); // Reset pagination page
   }

   //Toggle approved status voor klein scherm
    public function toggleApproved($lineId)
    {
        // Find the line by ID
        $line = Review::findOrFail($lineId);

        // Toggle the is_approved status
        $line->is_approved = !$line->is_approved;

        // Save the changes
        $line->save();
    }


    #[Layout('layouts.huiskamer', ['title' => 'Reviews', 'description' => 'Hier kan je de reviews beheren.'])]
    public function render()
    {
        $query = Review::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->searchColumns($this->search);

        if ($this->showOnlyPending !== null) {
            $query->where('is_approved', $this->showOnlyPending);
        }

        $firstLine = $query->first();
        if ($firstLine) {
            $attributes = array_keys($query->first()->getAttributes());
            $this->columns = array_diff($attributes, ['id', 'updated_at', 'created_at']);
        } else {
            $this->columns = [];
        }

        $lines = $query->paginate($this->perPage);

        return view('livewire.admin.reviews', compact('lines'));
    }


}

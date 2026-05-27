<?php

namespace App\Livewire\Admin;

use App\Models\Template_webpage; // Aanpassen!
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\WithFileUploads;


class Website extends Component // (app livewire admin ....) // Aanpassen!
{
    // sjabloon voor de tabel CRUD --------------------------------------
    // Template_webpages/cruds vervangen door ...s/...  en Template_webpage/crud door .../...
    public  $orderBy = 'id' ;
    public  $orderAsc = true ;
    public $columns = []; // Geef hier de kolommen op waarop je wilt zoeken, anders zijn het enkel de fillable kolommen
    public $search;
    public $includeAttributes = []; // Attributes to include
    public $excludeAttributes = ['id','updated_at', 'created_at' ]; // Attributes to exclude
    public $textareaColumns = ['content']; // kolommen waarvoor textarea moet genomen worden ipv text

    public $booleanColumns = []; // kolommen waarvoor checkbox moet genomen worden ipv text

    public $editing = false;
    public $editingLineId;
    public $perPage = 5;

    public $imageUploadable = ['home']; //kan ik foto's aanpassen met update




    use WithPagination, WithFileUploads;

    public $newImage;
    public $newImage2;



    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }


// variabelen aanpassen!
    public $newLine,
        $newLineType,
        $newLineContent,
        $newLinePicture_1,
        $newLinePicture_2;
    // Aanpassen!

// validatie regels

// Booleans opsommen en naar 0 zetten
    public $newLineActive = 0;  //laten staan


    // uitzondering op de unique rule bij edit (newLine veranderen naar newLineX.... indien er geen veld name is)
    public function rules()
    {
        return [
            'newLineType' => "required|min:3|max:30|unique:cruds,name,{$this->editingLineId}", // Aanpassen!
        ];
    }

    // $validationAttributes is used to replace the attribute name in the error message  (weergave voor errormessages)
    protected $validationAttributes = [
        'newLineType' => 'type',
    ];

    public function editLine($id) // Aanpassen!
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Template_webpage::findOrFail($id);

        $this->newLineType = $line->type;
        $this->newLineContent = $line->content;
        $this->newLinePicture_1 = $line->picture_1;
        $this->newLinePicture_2 = $line->picture_2;

        //Kan ik een foto aanpassen of niet
        $this->canEditImages = in_array($line->type, $this->imageUploadable);

    }

    public function resetFileInputs()
    {
        $this->newImage = null;
        $this->newImage2 = null;
    }

    public function createOrUpdate()
    {
        $this->validate();

        // Check if new images are uploaded
        $imageName1 = $this->newImage ? $this->newImage->storeAs('public/websitepictures', $this->newImage->getClientOriginalName()) : null;
        $imageName2 = $this->newImage2 ? $this->newImage2->storeAs('public/websitepictures', $this->newImage2->getClientOriginalName()) : null;

        // Prepare data for database update or creation
        $data = [
            'type' => $this->newLineType,
            'content' => $this->newLineContent,
            // Retain existing image paths if no new images are uploaded
            'picture_1' => $imageName1 ?? $this->newLinePicture_1,
            'picture_2' => $imageName2 ?? $this->newLinePicture_2,
        ];

        if ($this->editing) {
            // Update the existing record in edit mode
            $line = Template_webpage::findOrFail($this->editingLineId);
            $line->update($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->type) . "</i></b> is aangepast",
            ]);
        } else {
            // Create a new record in create mode
            $newLine = Template_webpage::create($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($newLine->type) . "</i></b> is toegevoegd",
            ]);
        }

        $this->resetValues();
        $this->resetFileInputs();
    }



    // reset all the values and error messages
    public function resetValues()
    {
        // Reset all the input fields
        $this->reset([
            'newLineType',
            'newLineContent',
            'newLinePicture_1',
            'newLinePicture_2',
            'newImage',
            'newImage2',
        ]);

        // Reset the editing flag and clear any error messages
        $this->editing = false;
        $this->resetErrorBag();
        $this->search = '';
    }



    #[On('delete-line')]

    public function delete($id)
    {
        $line = Template_webpage::findOrFail($id); // Aanpassen!
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($line->type) . "</i></b> is verwijderd",
        ]);
    }

    // eindesjabloon voor de tabel CRUD ------------------------------------------------------------

    #[Layout('layouts.huiskamer', ['title' => 'Website', 'description' => 'Op deze pagina kan je de sjablonen van je website beheren.'])]
    public function render()
    {
        $query = Template_webpage::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
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

        return view('livewire.admin.website', compact('lines'));
    }


}

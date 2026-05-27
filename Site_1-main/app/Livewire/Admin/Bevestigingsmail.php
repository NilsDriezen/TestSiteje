<?php

namespace App\Livewire\Admin;

use App\Models\Email_message;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class Bevestigingsmail extends Component
{
    use WithPagination;

    public $orderBy = 'id';
    public $orderAsc = true;
    public $columns = [];
    public $search;
    public $includeAttributes = [];
    public $excludeAttributes = ['updated_at', 'created_at'];
    public $textareaColumns = ['email_signature', 'email_content_admin', 'email_subject'];
    public $booleanColumns = [];
    public $editing = false;
    public $editingLineId;
    public $perPage = 5;
    public $newLineActive = false;

    public $newLine,
        $newLineType,
        $newLineEmail_content_admin,
        $newLineEmail_subject,
        $newLineEmail_signature
    ;

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    protected function rules()
    {
        return [
            'newLineType' => 'nullable|string|max:255',
            'newLineEmail_content_admin' => 'nullable|string|max:10000',
            'newLineEmail_subject' => 'nullable|string|max:255',
            'newLineEmail_signature' => 'nullable|string|max:10000',
        ];
    }

    public function editLine($id)
    {
        $this->editingLineId = $id;
        $this->editing = true;
        $line = Email_message::findOrFail($id);

        $this->newLineType = $line->type;
        $this->newLineEmail_content_admin = $line->email_content_admin;
        $this->newLineEmail_subject = $line->email_subject;
        $this->newLineEmail_signature = $line->email_signature;
    }

    public function createOrUpdate()
    {
        $this->validate();

        $data = [
            'type' => $this->newLineType,
            'email_content_admin' => $this->newLineEmail_content_admin,
            'email_subject' => $this->newLineEmail_subject,
            'email_signature' => $this->newLineEmail_signature,
        ];

        if ($this->editing) {
            $line = Email_message::findOrFail($this->editingLineId);
            $line->update($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($line->type) . "</i></b> is aangepast",
            ]);
        } else {
            $newLine = Email_message::create($data);

            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "<b><i>" . ucfirst($newLine->type) . "</i></b> is toegevoegd",
            ]);
        }

        $this->resetValues();
    }

    public function resetValues()
    {
        $this->reset(['newLineType', 'newLineEmail_content_admin', 'newLineEmail_subject', 'newLineEmail_signature','editing']);
        $this->resetErrorBag();
        $this->search = '';
    }

    public function updated($property)
    {
        if (in_array($property, ['perPage', 'search'])) {
            $this->resetPage();
        }
    }

    #[On('delete-line')]
    public function delete($id)
    {
        $line = Email_message::findOrFail($id);
        $line->delete();
        $this->resetPage();
        $this->resetValues();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($line->type) . "</i></b> is verwijderd",
        ]);
    }

    #[Layout('layouts.huiskamer', ['title' => 'Bevestigingsmail', 'description' => 'Hier kan je de informatie uit je basis mails bewerken.'])]
    public function render()
    {
        $query = Email_message::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->searchColumns($this->search);

        if ($query->exists()) {
            $this->columns = array_keys($query->first()->getAttributes());
            $this->columns = array_diff($this->columns, $this->excludeAttributes);
        } else {
            $this->columns = [];
        }

        $lines = $query->paginate($this->perPage);

        return view('livewire.admin.bevestigingsmail', compact('lines'));
    }
}

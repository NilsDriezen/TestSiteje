<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\PersoneelForm;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;


class Personeel extends Component
{
    use WithPagination;
    public PersoneelForm $personeelForm;
    public $search;
    public $perPage = 3;
    public $showModal = false;

    public $status;


    public $orderAsc = true;
    public $orderBy = 'name';



    #[Layout('layouts.huiskamer', [
        'title' => 'Personeel',
        'subtitle' => 'Personeel',
        'description' => 'Adminpagina voor personeelsbeheer',
    ])]
    public function render()
    {

        $query = User::query()
            ->searchName($this->search);

        if ($this->status == 'false') {
            $query->where('active', 'like', false);
        }
        elseif ($this->status == true) {
            $query->where('active', 'like', true);
        }
        else {
            $query->where('active', 'like', '%');
        }

        $query->orderBy($this->orderBy === 'name' ? 'first_name' : $this->orderBy, $this->orderAsc ? 'asc' : 'desc');

        $users = $query->paginate($this->perPage);

        return view('livewire.admin.personeel', compact('users'));
    }


    // create a new user
    public function newUser()
    {
        $this->personeelForm->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    // create user
    public function createUser()
    {
        $this->personeelForm->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gebruiker <b><i>{$this->personeelForm->first_name} {$this->personeelForm->last_name}</i></b> is succesvol opgeslagen",
            'icon' => 'success',
        ]);
    }

    // edit user
    public function editUser(User $user)
    {
        $this->resetErrorBag();

        $this->personeelForm->fill($user);
        $this->showModal = true;
    }

    // update user
    public function updateUser($user)
    {
        $this->personeelForm->update($user);
        $this->showModal = false;
        $this->personeelForm->reset();
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gebruiker <b><i>{$this->personeelForm->first_name} {$this->personeelForm->last_name}</i></b> is succesvol bijgewerkt",
            'icon' => 'success',
        ]);
    }


    // delete
    #[On('delete-user')]
    public function delete($id){

        //voorkom dat de admin zijn eigen account verwijderd
            $currentUser = auth()->user();

            if ($currentUser->id == $id) {
                $this->dispatch('swal:toast', [
                    'background' =>'error',
                    'html' => "U kunt uw eigen account niet verwijderen",
                ]);
                return;
            }

            $user = User::findOrFail($id);
            $this->personeelForm->delete($user);
            $this->dispatch('swal:toast', [
                'background' =>'success',
                'html' => "<b><i>". ucfirst($user->first_name). "</i></b> is verwijderd",
            ]);

    }


    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

    public function updated($property, $value)
    {
        if (in_array($property, ['perPage','search', 'status'])) {
            $this->resetPage();
        }
    }


}

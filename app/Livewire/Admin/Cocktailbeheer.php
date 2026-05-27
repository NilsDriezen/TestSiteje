<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\CocktailForm;
use App\Models\Cocktail;
use App\Models\Dish;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Cocktailbeheer extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search;
    public $name;
    public $description;
    public $price;
    public $priceMin, $priceMax;
    public $photo;
    public $date;
    public $perPage = 5;
    public $showModal = false;
    public CocktailForm $form;
    public $allDates = [];
    public $published;

    // reset the paginator
    public function updated($propertyName, $propertyValue)
    {
        if (in_array($propertyName, ['name', 'perPage']))
            $this->resetPage();
    }

    public function mount()
    {
        $this->priceMin = ceil(Cocktail::min('price'));
        $this->priceMax = ceil(Cocktail::max('price'));
        $this->price = $this->priceMax;
        $this->published = false;
    }

    public function resetFilters()
    {
        $this->name = '';
        $this->published = false;
        $this->price = $this->priceMax;

        // Reset the pagination page to 1
        $this->resetPage();
    }

    public function resetFileInputs()
    {
        $this->photo = '/storage/cocktailphotos/no-photo.jpg';;
    }

    public function newCocktail()
    {
        $this->form->reset();
        $this->resetFileInputs();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createCocktail()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Cocktail toegevoegd',
            'timeout' => 3000,
            'icon' => 'success'
        ]);
    }

    public function editCocktail(Cocktail $cocktail)
    {
        $this->form->fill($cocktail);
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function updateCocktail(Cocktail $cocktail)
    {
        $this->form->update($cocktail);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Cocktail bijgewerkt',
            'timeout' => 3000,
            'icon' => 'success'
        ]);
    }

    public function deleteCocktail(Cocktail $cocktail)
    {
        if($cocktail->date == null) {
            $this->form->delete($cocktail);
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'title' => 'Cocktail verwijderd',
                'timeout' => 3000,
                'icon' => 'success'
            ]);
        } else {
            $this->dispatch('swal:confirm', [
                'type' => 'error',
                'title' => 'Deze cocktail staat gepubliceerd',
                'text' => 'Verwijderen niet mogelijk',
                'icon' => 'error',
                'showCancelButton' => false,
                'showConfirmButton' => false,
                'showDenyButton' => true,
                'denyButtonText' => 'OK'
            ]);
        }
    }

    #[Layout('layouts.huiskamer', [
        'title' => 'Cocktails',
        'subtitle' => 'Cocktails',
        'description' => 'Beheer hier je cocktails.'
    ])]
    public function render()
    {
        $dishes = Dish::orderBy('id')
            ->where('course_id', '=', '5')
            ->orWhere('course_id', '=', '7')
            ->get();
        $query = Cocktail::orderByRaw('-date DESC')
            ->with('dish')
            ->where('price', '<=', $this->price)
            ->where(function ($query) {
                $query->where('name', 'like', "%{$this->name}%")
                    ->orWhere('description', 'like', "%{$this->name}%");
            });
        if($this->published) {
            $query->whereNotNull('date');
        }
        $cocktails = $query->paginate($this->perPage);
        return view('livewire.admin.cocktailbeheer', compact('cocktails', 'dishes'));
    }
}

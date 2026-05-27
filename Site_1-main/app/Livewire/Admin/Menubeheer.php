<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\MenuForm;
use App\Models\Dish;
use App\Models\Menu;
use App\Models\Menu_dish;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;



class Menubeheer extends Component
{
    use WithPagination;

    public $name;
    public $is_veggie;
    public $publishDate = false;
    public $menu;
    public $price_3_course;
    public $price_3_courseMin, $price_3_courseMax;
    public $perPage = 5;
    public $showModal = false;
    public MenuForm $form;
    public $menuIsVeggie = [];
    public $published;



    // reset the paginator
    public function updated($propertyName, $propertyValue)
    {
        if (in_array($propertyName, ['name', 'perPage', 'date', 'is_veggie']))
            $this->resetPage();
    }

    public function mount()
    {
        $this->price_3_courseMin = ceil(Menu::min('price_3_course'));
        $this->price_3_courseMax = ceil(Menu::max('price_3_course'));
        $this->price_3_course = $this->price_3_courseMax;
        $this->published = false;
    }

    public function resetFilters()
    {
        $this->name = '';
        $this->is_veggie = null;
        $this->published = false;
        $this->price_3_course = $this->price_3_courseMax;

        // Reset the pagination page to 1
        $this->resetPage();
    }


    public function updatedMenuIsVeggie($menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $menu->update(['is_veggie' => $this->menuIsVeggie[$menuId]]);
    }

    public function newMenu()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createMenu()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Menu toegevoegd',
            'timeout' => 3000,
            'icon' => 'success'
        ]);
    }

    public function editMenu(Menu $menu)
    {
        $this->form->read($menu);
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function updateMenu(Menu $menu)
    {
        $this->form->update($menu);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Menu bijgewerkt',
            'timeout' => 3000,
            'icon' => 'success'
        ]);
    }

    public function deleteMenu(Menu $menu)
    {
        if($menu->date == null) {
        $this->form->delete($menu);
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'title' => 'Menu verwijderd',
            'timeout' => 3000,
            'icon' => 'success'
        ]);
        } else {
            $this->dispatch('swal:confirm', [
                'type' => 'error',
                'title' => 'Deze menu staat gepubliceerd',
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
        'title' => 'Menu\'s',
        'subtitle' => 'Menu\'s',
        'description' => 'Beheer hier je menu\'s.'
    ])]
    public function render()
    {
        $query = Menu::with('menu_dishes.dish')
            ->when($this->name, function ($query) {
                $query->where('name', 'like', '%' . $this->name . '%')
                    ->orWhereHas('menu_dishes.dish', function ($query) {
                        $query->where('name', 'like', '%' . $this->name . '%');
                    });
            })
            ->when($this->is_veggie !== null, function ($query) {
                $query->where('is_veggie', $this->is_veggie);
            })
            ->when($this->published, function ($query) {
                $query->whereNotNull('date');
            })
            ->where('price_3_course', '<=', $this->price_3_course);

        $menus = $query
            ->orderByRaw('-date DESC')
            ->paginate($this->perPage);

        $voorgerechten = Dish::where('course_id', 1)->get();
        $tussengerechten = Dish::where('course_id', 2)->get();
        $hoofdgerechten = Dish::where('course_id', 3)->get();
        $desserts = Dish::where('course_id', 4)->get();

        return view('livewire.admin.menubeheer', compact('menus', 'voorgerechten', 'tussengerechten', 'hoofdgerechten', 'desserts'));
    }
}

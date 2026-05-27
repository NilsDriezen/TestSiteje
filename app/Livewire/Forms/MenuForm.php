<?php

namespace App\Livewire\Forms;

use App\Models\Dish;
use App\Models\Menu;
use App\Models\Menu_dish;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MenuForm extends Form
{
    public $id = null;
    #[Validate('required', as: 'naam van de menu')]
    public $name = '';
    #[validate('required', as: 'voorgerecht')]
    public $voorgerecht;
    #[validate('required', as: 'tussengerecht')]
    public $tussengerecht;
    #[validate('required', as: 'hoofdgerecht')]
    public $hoofdgerecht;
    #[validate('required', as: 'dessert')]
    public $dessert;
    #[Validate('required', as: 'vegetarisch')]
    public $is_veggie = false;
    #[Validate('required', as: 'prijs 3-gangen')]
    public $price_3_course;
    #[Validate('required', as: 'prijs 4-gangen')]
    public $price_4_course;
    #[Validate('nullable|unique:menus', as: 'datum')]
    public $date;

    //    read the selected menu
    public function read($menu)
    {
        $this->id = $menu->id;
        $this->name = $menu->name;
//        $this->is_veggie = $menu->is_veggie;
            if ($menu->is_veggie == 1) {
                $this->is_veggie = true;
            } else {
                $this->is_veggie = false;
            }
        $this->price_3_course = $menu->price_3_course;
        $this->price_4_course = $menu->price_4_course;
        $this->date = $menu->date;
        $menu_dishes = Menu_dish::where('menu_id', $menu->id)->get();
        foreach ($menu_dishes as $menu_dish) {
            if ($menu_dish->dish->course_id == 1) {
                $this->voorgerecht = $menu_dish->dish->id;
            }
            if ($menu_dish->dish->course_id == 2) {
                $this->tussengerecht = $menu_dish->dish->id;
            }
            if ($menu_dish->dish->course_id == 3) {
                $this->hoofdgerecht = $menu_dish->dish->id;
            }
            if ($menu_dish->dish->course_id == 4) {
                $this->dessert = $menu_dish->dish->id;
            }
        }

    }

    protected $validationAttributes = [
        'date' => 'datum',
    ];

//    create a new menu
    public function create()
    {
        if ($this->date != null && $this->is_veggie) {
            $this->date = $this->date . '-01';
        }
        elseif ($this->date != null && !$this->is_veggie) {
            $this->date = $this->date . '-02';
        }
        else {
            $this->date = null;
        }

        $this->validate();
        $menu = Menu::create([
            'name' => $this->name,
            'is_veggie' => $this->is_veggie,
            'price_3_course' => $this->price_3_course,
            'price_4_course' => $this->price_4_course,
            'date' => $this->date,
        ]);
//        voorgerecht
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->voorgerecht,
        ]);
        // tussengerecht
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->tussengerecht,
        ]);
        // hoofdgerecht
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->hoofdgerecht,
        ]);
        // dessert
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->dessert,
        ]);
    }

//    update an existing menu
    public function update(Menu $menu) {

        if ($this->date != null && $this->is_veggie) {
            $this->date = $this->date . '-01';
        }
        elseif ($this->date != null && !$this->is_veggie) {
            $this->date = $this->date . '-02';
        }
        else {
            $this->date = null;
        }

        $this->validate();
        $menu->update([
            'name' => $this->name,
            'is_veggie' => $this->is_veggie,
            'price_3_course' => $this->price_3_course,
            'price_4_course' => $this->price_4_course,
            'date' => $this->date,
        ]);
        // Delete old menu dishes
        Menu_dish::where('menu_id', $menu->id)->delete();

        // Create new menu dishes
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->voorgerecht,
        ]);
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->tussengerecht,
        ]);
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->hoofdgerecht,
        ]);
        Menu_dish::create([
            'menu_id' => $menu->id,
            'dish_id' => $this->dessert,
        ]);
    }

//    delete the selected menu
    public function delete(Menu $menu)
    {
        $menu->delete();
    }
}

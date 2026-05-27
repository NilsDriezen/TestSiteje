<?php

namespace App\Livewire\Forms;

use App\Models\Dish;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GerechtForm extends Form
{

    public $id = null;
    #[Validate('required', as: 'naam van het gerecht')]
    public $name = null;
    public $instruction = null;
    #[Validate('required', as: 'recepttag')]
    public $recipe_tag = null;
    #[Validate('required', as: 'bereidingstijd')]
    public $preparation_time = null;
    #[Validate('required', as: 'aantal personen')]
    public $serving = null;
    #[Validate('required', as: 'kooktijd')]
    public $cooking_time = null;
    #[Validate('required', as: 'calorieën')]
    public $calorie = null;
    #[Validate('required', as: 'type gang')]
    public $course_id = null;
    public $comment = null;
    //public/storage/dishpictures/no-photo.png

    public $path = '/storage/dishpictures/no-photo.png';
    /*#[Validate('boolean', as: 'actief')]*/
    public $active = false;

    public function read($dish)
    {
        $this->id = $dish->id;
        $this->name = $dish->name;
        $this->instruction = $dish->instruction;
        $this->recipe_tag = $dish->recipe_tag;
        $this->preparation_time = $dish->preparation_time;
        $this->serving = $dish->serving;
        $this->cooking_time = $dish->cooking_time;
        $this->calorie = $dish->calorie;
        $this->course_id = $dish->course_id;
        $this->comment = $dish->comment;
        $this->path = $dish->path;
        $this->active = $dish->active;
    }

    public function create()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'instruction' => $this->instruction,
            'recipe_tag' => $this->recipe_tag,
            'preparation_time' => $this->preparation_time,
            'serving' => $this->serving,
            'cooking_time' => $this->cooking_time,
            'calorie' => $this->calorie,
            'course_id' => $this->course_id,
            'comment' => $this->comment,
            'path' => $this->path,
            'active' => $this->active,
        ];
        return Dish::create($data);
    }

    public function update(Dish $dish)
    {
       /* dd($dish);*/
        $this->validate();

        $dish->update([
            'name' => $this->name,
            'instruction' => $this->instruction,
            'recipe_tag' => $this->recipe_tag,
            'preparation_time' => $this->preparation_time,
            'serving' => $this->serving,
            'cooking_time' => $this->cooking_time,
            'calorie' => $this->calorie,
            'course_id' => $this->course_id,
            'comment' => $this->comment,
            'path' => $this->path,
            'active' => $this->active,
        ]);

    }

    public function delete(Dish $dish)
    {
        $dish->delete();
    }
}

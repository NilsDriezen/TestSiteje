<?php

namespace App\Livewire\Admin;

use App\Livewire\Forms\GerechtForm;
use App\Models\Course;
use App\Models\Dish;

// Aanpassen!
use App\Models\Dish_ingredient;
use App\Models\Ingredient;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\In;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;


class Gerechten extends Component
{
    use WithPagination;
    public GerechtForm $form;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $search = '';
    public $typeGang = '%';
    protected $queryString = ['search','showModal'];
    public $perPage = 5;

    // calorie filter
    public $calorieMin, $calorieMax;
    public $calorieFilter;
    // bereidingstijd filter
    public $preparation_timeMin, $preparation_timeMax;
    public $preparation_timeFilter;

    public $showModal = false;

    public $showInstructionsModal = false;
    public $editInstructionsAttr = false;


    //public $ingredients = [];
    public $selectedIngredients = [];
    //public $dish_ingredients = [];
    public $allIngredients = [];
    public $selectedDish = null;

    //public $dish = null;

    public $showIngredientsModal = false;




    // mount for the calorie filter
    public function mount($selectedDish = null)
    {
        $this->calorieMin = ceil(Dish::min('calorie'));
        $this->calorieMax = ceil(Dish::max('calorie'));
        $this->calorieFilter = $this->calorieMax;

        $this->preparation_timeMin = ceil(Dish::min('preparation_time'));
        $this->preparation_timeMax = ceil(Dish::max('preparation_time'));
        $this->preparation_timeFilter = $this->preparation_timeMax;


        $this->allIngredients = Ingredient::all();

        // Initialize $selectedIngredients with default values if necessary
        foreach ($this->allIngredients as $ingredient) {
            if (!isset($this->selectedIngredients[$ingredient->id])) {
                $this->selectedIngredients[$ingredient->id] = [
                    'selected' => false,
                    'quantity' => 0,
                    'measurement_unit' => '',
                ];
            }
        }

        if ($selectedDish) {
            $this->loadDishIngredients($selectedDish);
        }
    }
    public function openModal()
    {
        $this->showModal = true;
    }
    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }



    public function newDish()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->selectedIngredients = [];
        $this->selectedDish = null;
        $this->showModal = true;
    }

    public function createDish()
    {
        $newDish = $this->form->create();
        $this->selectedDish = $newDish->id;

        //$this->form->create();
        $this->saveIngredients();

        $this->dishes = Dish::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->searchName($this->search)
            ->maxCalorie($this->calorieFilter)
            ->maxPreparationTime($this->preparation_timeFilter)
            ->paginate($this->perPage);


        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($this->form->name) . "</i></b> is toegevoegd",
        ]);
    }


    public function editDish(Dish $dish)
    {
        $this->resetErrorBag();
        $this->form->fill($dish);
        $this->selectedDish = $dish->id;
        $this->loadDishIngredients($dish->id);
        $this->showModal = true;
    }

    function updateDish(Dish $dish)
    {
        $this->validate(['selectedIngredients' => 'array']);
        $this->form->update($dish);

        // Ensure selectedDish is set to the current dish's ID
        $this->selectedDish = $dish->id;

        $this->saveIngredients();

        $this->showModal = false;

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($this->form->name) . "</i></b> is aangepast",
            'icon' => 'success',
        ]);
    }


    // reset all the values and error messages
    public function resetValues() // Aanpassen!
    {
        $this->editing = false;
        $this->form->reset();
    }

    public function updated($property, $value)
    {
        if (in_array($property, ['perPage', 'search','typeGang', 'calorieFilter', 'preparation_timeFilter', 'selectedDish', 'selectedIngredients'])) {
            $this->resetPage();
        }

    }


    // delete a dish
    #[On('delete-dish')]
    public function delete($id)
    {
        $dish = Dish::findOrFail($id);
        // Check if the dish is still referenced in the cookie_order_lines table
        $isReferenced = DB::table('cookie_order_lines')->where('cookie_id', $id)->exists();

        if ($isReferenced) {
            // Dispatch a toast message and return from the method
            $this->dispatch('swal:toast', [
                'background' => 'error',
                'html' => "<b><i>Gerecht met ID " . $id . "</i></b> kan niet worden verwijderd omdat het nog steeds wordt gebruikt in bestellingen.",
                'icon' => 'error',
            ]);
            return;
        }

        // Delete the dish

        $this->form->delete($dish);

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>Het gerecht " . $dish->name . "</i></b> is verwijderd",
            'icon' => 'success',
        ]);


    }


    public function read(Dish $id)
    {
        $this->form->read($id);
        $this->showModal = true;
    }
    public function toggleActive(Dish $id)
    {
        $id->update([
            'active' => !$id->active,
        ]);
        //$this->form->update($id);
        $message = $id->active ? 'geactiveerd' : 'gedeactiveerd';

        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<b><i>" . ucfirst($id->name) . "</i></b> is " . $message,
        ]);

    }

    public function showInstructions(Dish $id)
    {
        $this->form->read($id);
        $this->showInstructionsModal = true;
    }

    public function editInstructions(Dish $id)
    {
        $this->form->read($id);
        $this->editInstructionsAttr = true;
    }

    public function updateInstructions(Dish $dish)
    {
        $this->form->update($dish);
        $this->editInstructionsAttr = false;
    }



    public function saveIngredients()
    {
        $dish = Dish::find($this->selectedDish);

        if (!$dish) {
            $this->dispatch('swal:toast', [
                'background' => 'error',
                'html' => "Dish not found.",
                'icon' => 'error',
            ]);
            return;
        }

        $dish->dish_ingredients()->delete();

        foreach ($this->selectedIngredients as $ingredientId => $ingredientData) {
            if ($ingredientData['selected']) {
                $dish->dish_ingredients()->create([
                    'ingredient_id' => $ingredientId,
                    'quantity' => $ingredientData['quantity'] ?? 0,
                    'measurement_unit' => $ingredientData['measurement_unit'] ?? '',
                ]);
            }
        }
    }


    private function loadDishIngredients($dishId)
    {
        $dish = Dish::find($dishId);

        if (!$dish) {
            // Optionally add an error message or log this incident
            $this->addError('dishNotFound', 'Het geselecteerde gerecht bestaat niet.');
            return;
        }

        $this->selectedIngredients = [];

        foreach ($dish->dish_ingredients as $dishIngredient) {
            $this->selectedIngredients[$dishIngredient->ingredient_id] = [
                'selected' => true,
                'quantity' => $dishIngredient->quantity,
                'measurement_unit' => $dishIngredient->measurement_unit,
            ];
        }
    }


    #[Layout('layouts.huiskamer', ['title' => 'Gerechten', 'description' => 'Beheer gerechten'])]
    public function render()
    {

        $query = Dish::query();

        // Apply general search filter
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Apply Type gang filter
        if ($this->typeGang != '%') {
            $query->where('course_id', $this->typeGang);
        }

        // Apply additional filters like calorie and preparation time
        if (isset($this->calorieFilter)) {
            $query->where('calorie', '<=', $this->calorieFilter);
        }

        if (isset($this->preparation_timeFilter)) {
            $query->where('preparation_time', '<=', $this->preparation_timeFilter);
        }

        $dishes = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);


        //$dishes = $query->paginate($this->perPage);
        $recipe_tags = Course::all();

        $this->allIngredients = Ingredient::all();

        if ($this->selectedDish) {
            $this->loadDishIngredients($this->selectedDish);
        }

        return view('livewire.admin.gerechten', compact('dishes', 'recipe_tags'));
    }

}
/*$query = Dish::orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
          ->searchName($this->search)
          ->maxCalorie($this->calorieFilter)
          ->maxPreparationTime($this->preparation_timeFilter);*/

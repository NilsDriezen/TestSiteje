<?php

namespace App\Livewire\Forms;

use App\Models\Cocktail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class CocktailForm extends Form
{
    use WithFileUploads;

    public $id = null;
    #[Validate('required', as: 'naam van de cocktail')]
    public $name = '';
    public $photo = '/storage/cocktailphotos/no-photo.jpg';
    #[Validate('required', as: 'beschrijving')]
    public $description = '';
    #[Validate('required', as: 'prijs')]
    public $price;
    #[Validate('nullable|unique:cocktails', as: 'datum')]
    public $date;
    public $dish_id = 1;
    #[Validate('image|max:1024', as: 'foto')]
    public $newPhoto;

//    read the selected cocktail
    public function read($cocktail)
    {
        $this->id = $cocktail->id;
        $this->name = $cocktail->name;
        $this->photo = $cocktail->photo;
        $this->description = $cocktail->description;
        $this->price = $cocktail->price;
        $this->date = $cocktail->date;
        $this->dish_id = $cocktail->dish_id;
    }

    protected $validationAttributes = [
        'date' => 'datum',
    ];


//    create a new cocktail
    public function create()
    {
        if ($this->date != null) {
            $this->date = $this->date . '-01';
        }
        else {
            $this->date = null;
        }

        $this->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'date' => 'nullable|unique:cocktails',
        ]);

        if($this->newPhoto) {
            $filename = str_replace(' ', '_', strtolower($this->name)) . '.jpg';
            $storedPath = $this->newPhoto->storeAs('public/cocktailphotos', $filename);
            $photoPath = str_replace('public/', 'storage/', $storedPath);
        } else {
            $photoPath = '/storage/cocktailphotos/no-photo.jpg';
        }

        Cocktail::create([
            'name' => $this->name,
            'photo' => $photoPath,
            'description' => $this->description,
            'price' => $this->price,
            'dish_id' => $this->dish_id,
            'date' => $this->date,
        ]);

//        $temps = \Storage::disk('local')->files('livewire-tmp');
//        foreach ($temps as $temp) {
//            Storage::disk('local')->delete($temp);
//        }
    }

//    update an existing cocktail
    public function update(Cocktail $cocktail) {
        if ($this->date != null) {
            $this->date = $this->date . '-01';
        }
        else {
            $this->date = null;
        }
        $this->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'date' => 'nullable|unique:cocktails,date,' . $cocktail->id,
            ]
        );

        // If a new photo is uploaded, handle its storage and path
        if ($this->newPhoto) {
            $img = Image::make($this->newPhoto->getRealPath())->fit(275, 183)->encode('jpg', 75);
            $imgPath = 'cocktailphotos/' . str_replace(' ', '_', strtolower($this->name)) . '.jpg';
            Storage::disk('public')->put($imgPath, $img, 'public');
            $photoPath = 'storage/' . $imgPath;
        } else {
            $photoPath = $cocktail->photo; // Use existing photo path if no new photo is uploaded
        }

        $cocktail->update([
            'name' => $this->name,
            'photo' => $photoPath,
            'description' => $this->description,
            'price' => $this->price,
            'date' => $this->date,
            'dish_id' => $this->dish_id,
        ]);
    }

//    delete the selected cocktail
    public function delete(Cocktail $cocktail)
    {
        $cocktail->delete();
    }
}

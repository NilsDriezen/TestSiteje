<?php

namespace App\Livewire\Admin;

use App\Models\Dish;
use Image;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class GerechtenPictures extends Component
{
    use WithFileUploads;
    public $showModal = false;
    public $dish = null;
    #[Validate('required|image|mimes:jpg,jpeg,png,webp|max:1024')]
    public $newPicture;
    public $redundantCovers = [];
    public $newDishPath = null;

    // open modal to upload a new picture
    public function openModal()
    {
        $this->reset('newPicture');
        $this->resetValidation();
        $this->showModal = true;
    }

    // Get the uploaded picture and save it to the disk
    public function savePicture()
    {
        $this->validateOnly('newPicture');
        $picture = Image::make($this->newPicture->getRealPath())->fit(259, 194)->encode('jpeg', 100);
        $this->saveToDisk($picture);

        // Delete all temporary files from the livewire-tmp directory (optional)
        $files = Storage::disk('local')->files('livewire-tmp');
        foreach ($files as $file) {
            Storage::disk('local')->delete($file);
        }
    }

    // Save the picture to the disk
    public function saveToDisk($picture)
    {
        $basePath = 'dishpictures/';
        $publicPath = 'storage/dishpictures/';

        if ($this->dish->path) {
            // Delete the old picture from the disk
            $path = str_replace($publicPath, $basePath, $this->dish->path);
            Storage::disk('public')->delete($path);
        }

        // Create a new path for the picture
        $dishName = strtolower(str_replace(' ', '-', $this->dish->name));
        $dishName = $this->removeChar($dishName);
        $this->newDishPath = $basePath . $dishName . '.jpeg';

        // Save the picture to the disk
        Storage::disk('public')->put($this->newDishPath, $picture, 'public');

        // Update the dish path and reset the modal
        $this->dish->update(['path' => $publicPath . $dishName . '.jpeg']);
        $this->reset('newPicture', 'showModal');
    }


    // Delete the picture from the disk
    #[On('delete-picture')]
    public function deletePicture($redundantPicture = null)
    {
        if ($redundantPicture) {
            $this->redundantCovers = array_diff($this->redundantCovers, [$redundantPicture]);
            Storage::disk('public')->delete(str_replace('storage/', '', $redundantPicture));
            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "Overbodige foto succesvol verwijderd.",
                'icon' => 'success',
            ]);
        } else {
            $picPath = ltrim($this->dish->path, 'storage/');
            Storage::disk('public')->delete($picPath);
            $this->dish->update(['path' => 'storage/dishpictures/no-photo.png']);
            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "Foto van gerecht succesvol verwijderd.",
                'icon' => 'success',
            ]);
        }
    }

    public function mount($id = null)
    {
        if ($id) {
            // get the selected dish if id is not null
            $this->dish = Dish::findOrFail($id);
        } else {
            // get all the redundant pictures from the disk
            $pictures = Storage::disk('public')->files('dishpictures');
            $pictures = array_map(function ($picture) {
                return 'storage/' . $picture;
            }, $pictures);

             // get all the dishes from the records table
            $dishes = Dish::get();
            $dbPictures = [];
            foreach ($dishes as $d) {
                $dbPictures[] = ltrim($d->path, '/');
            }

            // remove placeholder from the array
            $pictures = array_diff($pictures, ['storage/dishpictures/no-photo.png']);
               // limit $covers to the covers that are not in the $dbCovers array
            $pictures = array_diff($pictures, $dbPictures);
            $this->redundantCovers = $pictures;
        }
    }

    #[Layout('layouts.huiskamer', ['title' => "Beheer Foto's Gerechten",])]
    public function render()
    {
        $dishes = Dish::orderBy('name')->get();
        return view('livewire.admin.gerechten-pictures', compact('dishes'));
    }

    function removeChar($str) {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }
}

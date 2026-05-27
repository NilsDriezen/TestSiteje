<?php

namespace App\Livewire\Admin;

use App\Models\Cookie;
use Image;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;

class CookiePictures extends Component
{

    use withfileuploads;

    public $showModal = false;
    public $cookie = null;
    #[Validate('required|image|mimes:jpg,jpeg,png,webp|max:1024')]
    public $newPicture;
    public $redundantPictures = [];


    //
    public function goBack()
    {
// go back to the previous page
//        dd('goBack method called');
//        return redirect()->back();
        return redirect()->route('admin.cookies');
    }


// open modal to upload a new picture
    public function openModal()
    {

        $this->reset('newPicture');
        $this->resetValidation();
        $this->showModal = true;
    }

// get the uploaded picture and save it to the disk
    public function savePicture()
    {
        $quality = 80;
        $this->validateOnly('newPicture');

        $picture = Image::make($this->newPicture->getRealPath())
            ->orientate()
            ->resize(640, 852, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->encode('jpg', $quality);


        $this->saveToDisk($picture);

        // delete all temporary files from the livewire-tmp directory (optional)
        $files = Storage::disk('local')->files('livewire-tmp');
        foreach ($files as $file) {
            Storage::disk('local')->delete($file);
        }

    }

// save the picture to the disk
    public function saveToDisk($picture)
    {
        $picturePath = 'cookiepictures/cookie_' . $this->cookie->id . '.jpg';
        Storage::disk('public')->put($picturePath, $picture, 'public');
        $this->reset('newPicture', 'showModal');

    }

// delete the picture from the disk
    #[On('delete-picture')]
    public function deletePicture($redundantPicture = null)
    {
        if ($redundantPicture) {
            $this->redundantPictures = array_diff($this->redundantPictures, [$redundantPicture]);
            Storage::disk('public')->delete($redundantPicture);
        } else {
            $pictureName = 'cookiepictures/cookie_' . $this->cookie->id . '.jpg';
            Storage::disk('public')->delete($pictureName);
        }
    }


    public function mount($id = null)
    {
        if (session('openModal')) {
            $this->openModal();
        }

        if ($id) {
            // get the selected cookie if id is not null
            $this->cookie = Cookie::findOrFail($id);
        } else {
            // get all the pictures from the disk
            $pictures = Storage::disk('public')->files('cookiepictures');
            // remove placeholder.png from the array
            $pictures = array_diff($pictures, ['cookiepictures/placeholder.png']);
            $this->redundantPictures = $pictures;
            // get all the cookies from the database
            $cookies = Cookie::get();
            $dbPictures = [];
            // loop through all the cookies
            foreach ($cookies as $cookie) {
                $dbPictures[] = 'cookiepictures/cookie_' . $cookie->id . '.jpg';
            }
            // remove the pictures that are in the database from the array
            $this->redundantPictures = array_diff($pictures, $dbPictures);
        }

    }

    #[Layout('layouts.huiskamer', ['title' => "Beheer Foto's Koekjes", ])]
    public function render()
    {
        $query = Cookie::orderBy('name')

            ->get();
        $cookies = $query;
        return view('livewire.admin.cookie-pictures', compact('cookies'));
    }
}

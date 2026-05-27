<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PersoneelForm extends Form
{
    public $id = null;


    #[Validate('required', as: 'voornaam van de gebruiker')]
    public $first_name = null;


    #[Validate('required', as: 'achternaam van de gebruiker')]
    public $last_name = null;

    #[Validate('required|email|unique:users,email', as: 'e-mail van de gebruiker')]
    public $email = null;

    #[Validate('required', as: 'telefoonnummer van de gebruiker')]
    public $phone_number = null;

    #[Validate('required|min:6|confirmed', as: 'wachtwoord van de gebruiker')]
    public $password = null;

    #[Validate('required|min:6', as: 'bevestiging van wachtwoord van de gebruiker')]
    public $password_confirmation = null;


    #[Validate('nullable', as: 'admin van de gebruiker')]
    public $admin = null;

    #[Validate('nullable', as: 'actief van de gebruiker')]
    public $active = null;

    public function read(User $user)
    {
        $this->id = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->active = $user->active;
        $this->admin = $user->admin;
    }

    public function create()
    {
        $this->validate();
        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'password' => Hash::make($this->password),
            'active' => $this->active ?? false,
            'admin' => $this->admin ?? false,
        ]);


    }

    public function update($id)
    {
        $this->validateUpdate();
        $user = User::find($id);

        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'active' => $this->active ?? false,
            'admin' => $this->admin ?? false,
        ];

        $user->update($data);


    }

    public function validateUpdate()
    {
        return $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'active' => 'nullable',
            'admin' => 'nullable',
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();
    }

}

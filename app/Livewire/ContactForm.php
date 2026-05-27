<?php

namespace App\Livewire;

use App\Mail\ContactMail;
use App\Models\Email_message;
use Illuminate\Mail\Mailables\Address;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mail;

class ContactForm extends Component
{
    #[Validate('required|min:3|max:50')]
    public $name;
    #[Validate('required|email')]
    public $email;
    #[Validate('required|min:10|max:500')]
    public $message;
    public $canSubmit = false;

    public function updated($propertyName, $propertyValue)
    {
        $this->canSubmit = false;
        $this->validateOnly($propertyName);
        if (count($this->getErrorBag()->all()) === 0)
            $this->canSubmit = true;
    }

    public function sendEmail()
    {
        $this->validate();

        // Fetch the email message from the database
        $emailMessage = Email_message::where('type', 'contact_confirmation')->first();

        // Set the signature to the email_signature fetched from the database, or a default if not found
        $signature = $emailMessage ? $emailMessage->email_signature : 'Best regards';
        $emailContentAdmin = $emailMessage ? $emailMessage->email_content_admin : '';

        // Create an instance of ContactMail and pass the data array including the signature
        $template = new ContactMail([
            'fromName' => 'Huiskamer - Mieke',
            'fromEmail' => 'info@huiskamer.be',
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
            'signature' => $signature,
            'emailContentAdmin' => $emailContentAdmin,
        ]);

        // Send the email
        $to = [
            new Address($this->email, $this->name),
            new Address('info@huiskamerrestaurant.be', 'Mieke') //ons mailadres
        ];        Mail::to($to)
            ->send($template);

        // Display success message using the swal:toast event
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "<p class='font-bold mb-2'>Beste $this->name,</p>
                   <p>Bedankt voor jouw bericht. <br>Wij contacteren u zo snel mogelijk.</p>",
        ]);

        // Reset form fields
        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}

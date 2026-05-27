<?php

namespace App\Livewire\Forms;

use App\Helpers\Cart;
use App\Models\Email_message;
use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Mail\OrderConfirmation;
use Mail;


class CookieForm extends Form
{
    #[Validate('required')]
    public $name = null;
    #[Validate('required')]
    public $phoneNumber = null;
    #[Validate('required')]
    public $email = null;

    #[Validate('required')]
    public $date = null;

    #[Validate('required')]
    public $time = null;

    // $validationAttributes is used to replace the attribute name in the error message  (weergave voor errormessages)
    protected $validationAttributes = [
        'phoneNumber' => 'Telefoonnummer',
    ];

    public $notes = null;
    public $signature = 'huiskamerrestaurant';
    public $adminText = null;


    public function sendEmail($backorder){
        $message = '<p>Bedankt voor je bestelling!</p>';
        $message .= '<p><b>Overzicht:</b></p>';
        $message .= '<ul>';
        foreach (Cart::getCookies() as $cookies) {
            $message .= "<li>{$cookies['qty']} x {$cookies['name']} - {$cookies['description']} - €{$cookies['price']}</li>";
        }
        $message .= '</ul>';
        $message .= "<p>Totaalprijs: &euro; " . Cart::getTotalPrice() . "</p>";
        $message .= '<p><b>Afhaalgegevens:</b><br>';
        $message .= 'Datum: ' . date('d/m/Y', strtotime($this->date)) . '<br>';
        $message .= 'Tijdstip: '. $this->time . '</p>';
        $message .= '<p><b>Commentaar:</b><br>';
        $message .= $this->notes . '</p>';
        if (count($backorder) > 0) {
            $message .= '<p><b>Zullen later moeten afgehaald worden:</b></p>';
            $message .= '<ul>';
            foreach ($backorder as $item) {
                $message .= "<li>{$item}</li>";
            }
            $message .= '</ul>';
        }

        $this ->adminText = Email_message::where('type', 'order_confirmation')->first()->email_content_admin;

        if ($this->adminText) {
            $message .= '<p><b>Extra:</b><br>';
            $message .= $this->adminText . '</p>';
        }

        // Get all admins
//        $admins = User::where('admin', true)->select('name', 'email')->get();


        $this ->signature = Email_message::where('type', 'order_confirmation')->first()->email_signature;


        $template = new OrderConfirmation([
            'message' => $message, 'name' => $this->name, 'email' => $this->email, 'signature' => $this ->signature
        ]);
        Mail::to($this->email)
            ->send($template);
    }


}

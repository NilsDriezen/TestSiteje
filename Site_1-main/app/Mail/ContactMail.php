<?php

namespace App\Mail;

use App\Models\Email_message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $onderwerp = 'Huiskamer - Contactformulier';
    public $signature = 'Mieke';
    public $email_content_admin;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailMessage = Email_message::where('type', 'contact_confirmation')->first();
        $this->onderwerp = $emailMessage->email_subject;
        $this->signature = $emailMessage->email_signature;
        $this->email_content_admin = $emailMessage->email_content_admin;

        return new Envelope(
            subject: $this->onderwerp,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

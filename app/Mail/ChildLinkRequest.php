<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChildLinkRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $parentName;
    public $relationship;
    public $confirmUrl;

    public function __construct(string $parentName, ?string $relationship, string $confirmUrl)
    {
        $this->parentName  = $parentName;
        $this->relationship = $relationship;
        $this->confirmUrl  = $confirmUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm parental control link request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.child_link_request',
        );
    }
}

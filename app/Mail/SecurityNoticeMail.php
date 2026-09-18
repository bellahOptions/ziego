<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SecurityNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $mailSubject,
        public string $heading,
        public string $intro,
        public string $buttonText,
        public string $buttonUrl,
        public string $closingNote,
        public string $icon = 'lock',
        public ?string $expiryNote = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->mailSubject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.security-notice',
            with: [
                'heading'     => $this->heading,
                'intro'       => $this->intro,
                'buttonText'  => $this->buttonText,
                'buttonUrl'   => $this->buttonUrl,
                'closingNote' => $this->closingNote,
                'icon'        => $this->icon,
                'expiryNote'  => $this->expiryNote,
            ],
        );
    }
}

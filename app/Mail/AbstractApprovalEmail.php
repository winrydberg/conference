<?php

namespace App\Mail;

use App\Models\Conference;
use App\Models\ConferenceAbstract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AbstractApprovalEmail extends Mailable
{
    use Queueable, SerializesModels;

    public ConferenceAbstract $abstract;
    public Conference $conference;
    /**
     * Create a new message instance.
     */
    public function __construct(ConferenceAbstract $abstract,  Conference $conference)
    {
        $this->abstract = $abstract;
        $this->conference = $conference;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'UG Conference | Abstract Approved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.abstractapproved',
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

<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\Conference;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewAbstractSubmissionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Application $application;
    public Conference $conference;
    public string $email;
    /**
     * Create a new message instance.
     */
    public function __construct(Application $application, Conference $conference, $email)
    {
        $this->application = $application;
        $this->conference = $conference;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'UG Conference | Abstract Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newabstract',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            storage_path('/app/public/emails/Abstract_Proof_Of_Registration'.$this->application->reg_no.'.pdf')
        ];
    }
}

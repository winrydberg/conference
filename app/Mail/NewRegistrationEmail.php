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
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class NewRegistrationEmail extends Mailable
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
            subject: 'UG Conference | Registration Successful',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.newregistration',
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
            storage_path('/app/public/emails/Proof_Of_Registration'.$this->application->reg_no.'.pdf')
        ];
    }
}

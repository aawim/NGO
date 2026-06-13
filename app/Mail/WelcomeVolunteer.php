<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeVolunteer extends Mailable
{
    use Queueable, SerializesModels;

    // Fixed: Removed the invalid 'clone' keyword here
    public User $user; 
    public $tempPassword;

    public function __construct(User $user, $tempPassword)
    {
        // Fixed: Standard assignment
        $this->user = $user;
        $this->tempPassword = $tempPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to the Team! Your Account Details',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.volunteer.welcome',
        );
    }
}
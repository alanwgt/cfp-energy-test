<?php

namespace App\Mail;

use App\Models\AdminInvite;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUserToBeAdmin extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public readonly AdminInvite $adminInvite)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'You have been invited to be an admin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.admin-invite',
        );
    }
}

<?php

namespace App\Mail;

use App\Models\Election;
use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoterInvited extends Mailable
{
    use Queueable, SerializesModels;
    public  $elections;
    public Invite $voter;
    public $urls = [];

    /**
     * Create a new message instance.
     */
    public function __construct($elections, $voter)
    {
        $this->elections = $elections;
        $this->voter = $voter;
        foreach ($elections as $election){
            $this->urls[$election->id] = route('election.vote', ['election' => $election->id]);
        };
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->election->name. ' Election Invitation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.voterInvited',
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

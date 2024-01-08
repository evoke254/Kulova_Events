<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventTicket extends Mailable
{
    use Queueable, SerializesModels;
    public Invite $user;
    public $event;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        if (!isset($user->ticket)){
            $user->createTicket();
        }
        $this->user = $user;
        $parts = explode("/", $user->ticket);
        $this->url = asset('images/tickets/'. end($parts));
        $this->event = Event::find($user->event_id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Ticket - ' . $this->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.event-tickets',
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
            Attachment::fromPath($this->user->ticket)
        ];
    }
}

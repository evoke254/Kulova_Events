<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class EventInvitation extends Mailable
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
        $this->user = $user;
        $this->url = URL::signedRoute('event.registration', ['user' => $user]);;
        $this->event = Event::find($user->event_id);
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        //SMS
        $sms = 'Dear Customer, You have been invited to attend '. $this->event->name .' Kindly click on the link below to register. '. $this->url;
        $this->user->sendSMS($this->user->phone_number, $sms);
        return new Envelope(
            subject: 'REGISTER FOR '. $this->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.eventInvitation',
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

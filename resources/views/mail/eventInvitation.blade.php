<x-mail::message>
# {{$voter->name}}, You have been invited to attend an event

Please find attached your ticket to  {{$event->name}}.
<x-mail::button :url="$url">
    View Ticket
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

<x-mail::message>
# {{$event->organization->name}},

**{{$user->name}}, You have been invited to attend an event**
Please click on the link below to register for the event
<x-mail::button :url="$url">
    Register
</x-mail::button>
#{{$url}}
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

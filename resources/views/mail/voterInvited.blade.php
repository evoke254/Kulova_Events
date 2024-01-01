<x-mail::message>
# {{$voter->name}}, You are invited to vote

Vote in {{$election->name}}

<x-mail::button :url="$url">
Vote
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

<x-mail::message>
# {{$voter->name}}, You are invited to vote

Vote in {{$election->name}}

@foreach($elections as $election)
<x-mail::button :url="$urls[$election]">
Vote
</x-mail::button>
 @endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

<x-mail::message>
# {{$voter->name}}, You are invited to vote

We are reaching out to invite you to participate in the following elections.
@foreach($elections as $key => $election)
{{$key+1}} {{$election->name}}
@endforeach
@foreach($elections as $election)
<x-mail::button :url="$urls[$election]">
Vote : {{$election->name}}
</x-mail::button>
 @endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

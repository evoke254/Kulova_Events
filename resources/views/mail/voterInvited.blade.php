<x-mail::message>
# {{$voter->name}}, You are invited to vote

We are reaching out to invite you to participate in  {{$event->name}} elections.
@foreach($elections as $key => $election)
{{$key+1}} {{$election->name}},
@endforeach
@foreach($elections as $election)
    @php
            $urlencodedtext = urlencode('Voter-'.$voter->id);
            $url = "https://wa.me/254792782923?text=". $urlencodedtext;
            @endphp
<x-mail::button :url="$url">
    WhatasApp {{$election->name}}
</x-mail::button>
<x-mail::button :url="$urls[$election->id]">
    Web : {{$election->name}}
</x-mail::button>
=========
 @endforeach

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

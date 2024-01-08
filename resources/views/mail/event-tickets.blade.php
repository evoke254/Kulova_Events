@component('mail::message')
# Event Registration Successful

Dear {{ $user->name }} {{ $user->last_name }},

Thank you for registering for the {{ $event->name }} event. Your registration was successful!

**Event Details:**
- **Event Name:** {{ $event->name }}
- **Venue:** {{ $event->venue }}
- **Start Date Time:** {{ \Carbon\Carbon::parse($event->start_date)->format('D, d M Y H:i')  }}
- **End Date Time:** {{  \Carbon\Carbon::parse($event->end_date)->format('D, d M Y H:i:s') }}

**Your Registration Details:**
- **Member Number:** {{ $user->member_no }}

We look forward to seeing you at the event!

@component('mail::button', ['url' => route('event.view', ['event', $event->id])])
View Event Details
@endcomponent
@if($user->ticket)
**We have attached your ticket**
@endif

If you have any questions or need further assistance, feel free to contact us.

Thank you,
@endcomponent

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

<table style="margin: 0 auto;">
    <tr>
        <td style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <img src="{{ asset($event->images()->first()->image) }}" alt="Event Image" style="display: block; margin: 0 auto; border-radius: 8px;">
        </td>
    </tr>
</table>

If you have any questions or need further assistance, feel free to contact us.

Thank you,
@endcomponent

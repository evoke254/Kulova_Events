<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\LaravelPdf\Facades\Pdf;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event.member');
    }

    public function tickets(Invite $user)
    {

        // Generate a unique QR code for the ticket
        $scanUrl = URL::signedRoute('attend.event', ['user' => $user]);

        $qrCode = QrCode::size(150)->generate($scanUrl);
        $event = Event::find($user->event_id);
        $ticket = Pdf::view('ticket', ['user' => $user, 'event' => $event, 'qrCode'=>$qrCode])
            ->format('a4')
            ->save('invoice.pdf');
        $user->ticket = $ticket;
        $user->save();
        return view('ticket', compact('user', 'qrCode', 'event'));

    }

    public function scanAttendance(Request $request, Invite $user)
    {
        if ($request->hasValidSignature()) {
            $event = Event::find($user->event_id);
            $prev_attendance = EventAttendance::where('invite_id', $user->id)->latest()->first();

            $event_attendance = new EventAttendance();
            $event_attendance->check_in_out = !$prev_attendance || !$prev_attendance->check_in_out;
            $event_attendance->invite_id = $user->id;
            $event_attendance->save();
            return view('welcome_event', compact('user', 'event'));
        } else {
            abort(403, 'Invalid or expired signature.');
        }
    }

    public function showAttendance(Invite $user){

        $attendance = $user->attendance()->get();

        $event = Event::find($user->event_id);
        return view('attendance', compact('user', 'attendance', 'event'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invite $invite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invite $invite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invite $invite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invite $invite)
    {
        //
    }
}

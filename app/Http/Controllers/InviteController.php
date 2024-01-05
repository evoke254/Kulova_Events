<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAttendance;
use App\Models\Invite;
use Barryvdh\Snappy\Facades\SnappyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        if (isset($user->ticket)){;
            File::delete(public_path($user->ticket));
        }
        // Generate a unique QR code for the ticket
        $scanUrl = URL::signedRoute('attend.event', ['user' => $user]);

        $qrCode = QrCode::size(150)->generate($scanUrl);
        $event = Event::find($user->event_id);
        $html = View::make('ticket', compact('user', 'qrCode', 'event'))->render();
        $path = public_path('images/tickets/'. time() . str_shuffle('bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLM') . '.png');
        SnappyImage::loadView('ticket', compact('user', 'qrCode', 'event'))
            ->setOption('enable-local-file-access', true)
            ->save($path);
        $user->ticket = $path;
        $user->save();


    }

    public function TestTicket(Invite $user){
        $scanUrl = URL::signedRoute('attend.event', ['user' => $user]);

        $route = route('event.ticket', ['user' => $user]);
        //     dd($route);
        Browsershot::url($route)
            ->select('.ticketContent')
            ->setChromePath('/usr/bin/chromium-browser')
            ->waitUntilNetworkIdle()
            ->noSandbox()
            ->newHeadless()
            ->save(public_path('images/tickets/'. time() . str_shuffle('bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLM') . '.png'));

        $user->ticket = public_path('images/tickets/'. time() . str_shuffle('bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLM') . '.png');
        $user->save();
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

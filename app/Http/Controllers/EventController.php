<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
        /**
     * Show Frontend
     */
    public function showEvent(Event $event)
    {
        return view('event.showEvent', compact('event'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('event.index');
    }



//Display frontend
    public function display()
    {
        return view('event.frontend');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function vote(Event $event)
    {
        return view('event.vote', compact('event'));
    }

    public function voteOnline(Event $event)
    {
        return view('event.vote-online', compact('event'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {

        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {

        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}

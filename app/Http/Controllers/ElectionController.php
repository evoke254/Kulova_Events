<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Event;
use Illuminate\Http\Request;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $event = $event->toArray();
        return view('event.election.create', compact('event'));
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
    public function show(Election $election)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Election $election)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Election $election)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Election $election)
    {
        //
    }

        public function ussd(Request $request)
    {
        //
        dd($request->all());
    }


    public function vote(Election $election)
    {
        return view('event.election.vote', compact('election'));

    }
}

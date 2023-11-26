<?php

namespace App\Http\Controllers;

use App\Bot\Driver\ussd;
use BotMan\BotMan\Cache\LaravelCache;
use App\Models\Election;
use App\Models\Event;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
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
        $config = [
            // Your driver-specific configuration
            // "telegram" => [
            //    "token" => "TOKEN"
            // ]
        ];
    //    DriverManager::loadDriver(ussd::class);
        $botman = BotManFactory::create($config, new LaravelCache());

        dd($request->all());
        $botman->hears('', function($bot) {
            $bot->reply("CON Welcome to Text-40 Digital Voting System. I'm here to assist you cast your vote.\n
            1. Browse Events\n
            00 : Cancel
             ");
            $bot->startConversation(new \App\Bot\ussdVoting);
        });

        // Start listening
        $botman->listen();
    }


    public function vote(Election $election)
    {
        return view('event.election.vote', compact('election'));

    }
}

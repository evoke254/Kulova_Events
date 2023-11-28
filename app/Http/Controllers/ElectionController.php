<?php

namespace App\Http\Controllers;

use App\Bot\Driver\ussd;
use App\Models\Invite;
use App\Models\Ussd_Call;
use BotMan\BotMan\Cache\LaravelCache;
use App\Models\Election;
use App\Models\Event;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\Facades\Log;

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
        /*$request->=> $phoneNumber,
        $request->=> $serviceCode,
        $request->=> $sessionId,
        $request->=> $text,
       */

        $config = $request->all();

          Ussd_Call::updateOrCreate(  ['sessionId' => $config['sessionId']],        $config  );
          DriverManager::loadDriver(ussd::class);

        // Log::info(json_encode($config));

        $botman = BotManFactory::create($config, new LaravelCache());
        $phoneNumber = $request->get('phoneNumber');

        //TODO remove in prod
        $rr = Invite::updateOrCreate(
            ['email' => time().'@gmail.com' ],
            ['phone_number' => $phoneNumber,
                'name' => 'test user 00',
                'email' => time().'@gmail.com',
                'event_id' => 4
                ]
        );

        $voterId = $rr;

        $botman->hears('', function($bot) use ($voterId) {
            $bot->startConversation(new \App\Bot\ussdVoting($voterId));
        });

        // Start listening
        $botman->listen();
    }


    public function vote(Election $election)
    {
        return view('event.election.vote', compact('election'));

    }
}

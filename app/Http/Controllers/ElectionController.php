<?php

namespace App\Http\Controllers;

use App\Bot\Driver\ussd;
use App\Bot\Driver\whatsapp;
use App\Models\Invite;
use App\Models\Ussd_Call;
use BotMan\BotMan\Cache\LaravelCache;
use App\Models\Election;
use App\Models\Event;
use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('event.election-index');
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
        return view('event.election-show', compact('election'));
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
        $config = $request->all();

        //   Ussd_Call::updateOrCreate(  ['sessionId' => $config['sessionId']],        $config  );
        // DriverManager::loadDriver(ussd::class);

        // Log::info(json_encode($config));

        $botman = BotManFactory::create($config, new LaravelCache());
        $phoneNumber = '+254742968713';

        $botman->hears('', function(Botman $bot) use ($phoneNumber) {
            $bot->startConversation(new \App\Bot\whatsappVoting($phoneNumber, 'Kev'));
        });
        $botman->listen();
    }


    public function whatsapp(Request $request)
    {
        $config = [
            'facebook' => [
                'from_number' => '+254742968713',
                'app_id' => '1048420159710452',
                'app_secret' => 'b80f0c714d7a726b5e317e5923938b3f',
                'token' => env('waba_admin_token'),
                'verification'=>'LoveLivesHere',
            ],
            'botman' => [
                'conversation_cache_time' => 300
            ],
        ];

        //Log::info(json_encode($config));
          DriverManager::loadDriver(whatsapp::class);
        $botman = BotManFactory::create($config, new LaravelCache());
        $phoneNumber = $request->get('entry')[0]['changes'][0]['value']['contacts'][0]['wa_id'];
        $userName = $request->get('entry')[0]['changes'][0]['value']['contacts'][0]['profile']['name'];
        $msg = $request->get('entry')[0]['changes'][0]['value']['messages'][0]['text']['body'];
        $voter = $this->isValidVoter($msg);
        if ($voter){
            if (substr($voter->phone_number, -9) ==  substr($phoneNumber, -9)){
                $botman->hears('', function($bot) use ($phoneNumber, $userName, $voter) {
                    $bot->startConversation(new \App\Bot\whatsappVoting($phoneNumber, $userName, $voter));
                });
            } else{
                $botman->hears('', function (BotMan $bot) {
                    $bot->reply("Invalid entry. Please use your registered phone number or vote online using the link in your email.");
                });
            }
        } else {

            $botman->hears('', function (BotMan $bot) use ($voter) {
                if ($voter){
                $bot->reply("Incorrect format. Please retry using the correct format: _Voter-". $voter->id);
                } else {
                $bot->reply("Incorrect format. Please retry using the correct format: _Voter-***_  ");
                }
            });

        }



        // Start listening
        $botman->listen();
    }


    function isValidVoter($str) {
        // Check if the string matches the pattern 'voter-<number>'
        if (preg_match('/^voter-(\d+)$/i', $str, $matches)) {
            $inviteId = $matches[1];
            $invite = Invite::find($inviteId);
            return $invite ? $invite : false;
        }

        // Check if the string is just a number
        if (is_numeric($str)) {
            // Check if an invite with the integer ID exists
            $invite = Invite::find($str);
            return $invite ? $invite : false;
        }

        // If the string doesn't match any of the patterns, return false
        return false;
    }


    public function setWatsappWebhook(Request $request)
    {
        $config = [
            'facebook' => [
                'from_number' => '+254742968713',
                'app_id' => '1048420159710452',
                'app_secret' => 'b80f0c714d7a726b5e317e5923938b3f',
                'token' => env('waba_admin_token'),
                'verification'=>'LoveLivesHere',
            ],
            'botman' => [
                'conversation_cache_time' => 300
            ],
        ];

        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);
        $botman = BotManFactory::create($config, new LaravelCache());

        $botman->hears('', function($bot)  {
            $bot->startConversation(new \App\Bot\facebookWebHook());
        });

        // Start listening
        $botman->listen();
    }




    public function vote(Request $request, Election $election, $voter_id=null)
    {
        if (!$request->hasValidSignature()) {
            return view('send-verification-sms', compact('election'));
        } else {
            $voter = Invite::find($voter_id);
            return view('event.election.vote', compact('election', 'voter'));
        }
    }

    private function sendVerificationSMS($phoneNumber)
    {

        $this->sendVerificationSMS(Auth::user()->phone);
    }

}

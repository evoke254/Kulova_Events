<?php

namespace App\Bot;

use App\Bot\Driver\whatsapp;
use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Vote;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\LaravelCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class facebookWebHook extends Conversation
{
    public function run(){

        $welcomeMessage = "Hello There.\n";
        $this->ask('Who is this?', function(Answer $answer) {
            $ans = (int) $answer->getText();
            if ($ans == 99){
                die();
            }
        });
    }



}

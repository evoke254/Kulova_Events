<?php

namespace App\Bot;

use App\Models\Election;
use App\Models\Event;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Str;

class ussdVoting extends Conversation
{
    public $event;
    public $voter;
    public $election;

    public function __construct()
    {
    }
    public function run(){
        $this->startConversation();
    }

    public function startConversation() {
//Display all events
        $events = Event::orderBy('start_date', 'Desc')
            ->get();

        $opt = '';
        foreach($events as $event) {
            $opt .= $event->id.': '.$event->name. ' \n';
        }
        $qstn = "CON Welcome to Text-40 Digital Voting System. I'm here to assist you cast your vote.\n
        Please select an event:\n".   $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {
            $this->event = Event::find($answer->getText());
            if ($this->event){
                $this->selectElection();
            } else{
                $qstn = "Invalid response. Please check and try again\n
                                Please select an event:\n".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }

        });
    }


    public function selectElection() {
        //$this->election =
        $elections =  $this->event->elections;
        $opt = '';
        foreach($elections as $election) {
            $opt .= '**'.Str::upper($election->name).'**';
            foreach ($election->elective_positions as $pstn){
                $opt .= $pstn->id.': '.$pstn->position. ' \n';
            }
        }

        $qstn = "ELECTIONS:\n".   $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {
            $this->election = Election::find($answer->getText());
            if ($this->election){
                $this->listElectivePositions();
            } else{
                $qstn = "Invalid response. Please check and try again\n
                                :\n".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }

        });

    }

    public function qstnFallback($qstn) {

        $this->repeat($qstn);
    }

    public function cancelConversation() {
        $this->say('END Canceled');
    }

    public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() == '00') {
            return true;
            $this->say('END Thanks for your submission.');
        }
        return false;
    }
}

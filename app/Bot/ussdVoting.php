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
    public $event; public $events;
    public $voter;
    public $election; public $elections;
    public $positions;
    public $candidates;

    public function __construct()
    {
    }
    public function run(){
        $this->startConversation();
    }

    public function startConversation() {
//Display all events
        $this->events = Event::orderBy('start_date', 'Desc')
            ->get()->toArray();

        $opt = "";
        foreach($this->events as $key => $event) {
            $opt .= $key+1 . ": ". $event['name']. " \n ";
        }
        $qstn = "CON  Welcome to Text-40 Digital Voting System. I'm here to assist you cast your vote. \n
        Please select an event: \n ".   $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {
            $ans = (int)$answer->getText();

            if (isset($this->events[$ans - 1])){
                $this->event = Event::find($this->events[$ans - 1]['id']);
                $this->selectElection();
            } else{
                $qstn = "CON Invalid response. Please check and try again \n
                                EVENTS: \n ".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }

        });
    }


    public function selectElection() {
        $this->elections =  $this->event->elections->toArray();

        $opt = "";
        foreach($this->elections as $key => $election) {
            $opt .= $key+1 . ": ".$election['name']. " \n ";
        }

        $qstn = "CON ELECTIONS: \n ".   $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {
            $ans = (int)$answer->getText();
            if (isset($this->elections[$ans - 1])){
                $this->election = Election::find($this->elections[$ans - 1]['id']);
                $this->selectElectivePositions();
            } else{
                $qstn = "CON  Invalid response. Please check and try again \n
                                : \n ".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }
        });

    }


    public function selectElectivePositions(){
        $this->positions = $this->election->elective_positions->toArray();
        $opt = "";
        foreach ($this->positions as $key => $pstn){
            $opt .= Str::upper($pstn['position']). " \n ";
            $this->candidates = $pstn['candidates'];
            foreach ($this->candidates as $candidate){
                   $opt .= $candidate['id'] . ": ".$candidate['name']. " \n ";
            }
        }
        $qstn = "POSITIONS: \n ".   $opt ." 00 : Cancel ";
        $this->ask($qstn, function(Answer $answer) use ($opt) {
            $ans = (int)$answer->getText();
            if (isset($this->elections[$ans - 1])){
                $this->election = Election::find($this->elections[$ans - 1]['id']);
                $this->selectElectivePositions();
            } else{
                $qstn = "CON  Invalid response. Please check and try again \n
                                : \n ".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }
        });

    }

    public function qstnFallback($qstn) {

        $this->repeat($qstn);
    }

    public function cancelConversation() {
        $this->say("END Canceled");
    }

    public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() == '00') {
            $this->say("END Thanks for your submission.");
            return true;
        }
        return false;
    }
}

<?php

namespace App\Bot;

use App\Models\Election;
use App\Models\Event;
use App\Models\Vote;
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
    public $votes = [];
    public $SelectedElectionArr;

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
                $this->elections =  $this->event->elections->toArray();
                $this->selectElection();
            } else{
                $qstn = "CON Invalid response. Please check and try again \n
                                EVENTS: \n ".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }

        });
    }


    public function selectElection() {

        $opt = "";
        foreach($this->elections as $key => $election) {
            $opt .= $key+1 . ": ".$election['name']. " \n ";
        }

        $qstn = "CON ELECTIONS: \n ".   $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {
            $ans = (int)$answer->getText();
            if (isset($this->elections[$ans - 1])){
                $this->election = Election::find($this->elections[$ans - 1]['id']);
                $this->SelectedElectionArr = $this->elections[$ans - 1];
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
        $countBallot = 0;
        $opt = "";
        foreach ($this->positions as $pstnKey => $pstn){
            if (empty($pstn['vote'])  && !empty($pstn['candidates'])) {
                $countBallot++;
                $opt .= Str::upper($pstn['position']). " \n ";
                $this->candidates = $pstn['candidates'];
                foreach ($this->candidates as $key => $candidate){
                    if ( isset($this->positions[$pstnKey]['vote']) && $this->positions[$pstnKey]['vote']['candidate_elective_position_id']    == $candidate['id']) {
                        $opt .= $key+1 . ": ".$candidate['name'] . " - ". $candidate['member_no'] ."**Elect  \n ";
                    } else {
                        $opt .= $key+1 . ": ".$candidate['name'] . " - ". $candidate['member_no'] ."  \n ";
                    }
                }
                break;
            }

        }

        if ($countBallot >0) {

            $qstn = "CON POSITIONS: \n ".   $opt ." 00 : Cancel ";
            $this->ask($qstn, function(Answer $answer) use ($opt, $pstnKey) {
                $ans = (int)$answer->getText();

                if (isset($this->positions[$pstnKey]) && isset($this->candidates[$ans - 1]['id']) ){
                    //Check if position has vote and delete
                    if (isset($this->positions[$pstnKey]['vote'])  && !empty($this->positions[$pstnKey]['vote']) ){
                        $prev_vote = Vote::find($this->positions[$pstnKey]['vote']['id']);
                        $prev_vote->delete();
                    }
                    $this->positions[$pstnKey]['vote'] = ['candidate_elective_position' => $this->candidates[$ans - 1]];

                    $castVote =  [
                        'elective_position_id' => $this->positions[$pstnKey]['id'],
                        'candidate_elective_position_id' => $this->candidates[$ans - 1]['id'],
                        'invite_id' => 1,
                        'vote' => 1,
                    ];
                    $vote = Vote::create($castVote);
                    array_push($this->votes, $vote);

                    $this->markBallot();
                } else{
                    $qstn = "CON  Invalid response. Please check and try again \n
                                : \n ".   $opt ." 00 : Cancel ";
                    $this->qstnFallback($qstn);
                }
            });


        } else {
            $this->confirmBallot();
        }

    }

    public function markBallot() {
        $myCastVotes = count($this->votes);
        $validVotes = 0;
        foreach ($this->positions as $pstnKey => $pstn){
            if (!empty($pstn['candidates'])) {
                $validVotes += 1;
            }
        }
        if ($myCastVotes != $validVotes){
            $this->selectElectivePositions();
        } else {
            $this->confirmBallot();
        }
    }

    public function confirmBallot(){

        $opt = "";
        foreach ($this->positions as $pstnKey => $pstn){

            $opt .= Str::upper($pstn['position']). " \n ";
            $this->candidates = $pstn['candidates'];
            foreach ($this->candidates as $key => $candidate){
                if ($candidate['id'] == $this->positions[$pstnKey]['vote']['candidate_elective_position_id']) {
                    $opt .= "- ".$candidate['name'] . " - ". $candidate['member_no'] ."**Elect  \n ";
                } else {
                    $opt .= "- ".$candidate['name'] . " - ". $candidate['member_no'] ."  \n ";
                }
            }
        }

        $qstn = "CON POSITIONS: \n ".   $opt ."\n 101 : Confirm\n 99 : Cancel ";
        $this->ask($qstn, function(Answer $answer) use ($opt, $pstnKey) {
            $ans = (int)$answer->getText();
            if ($ans == 101){
                $this->say('END Vote cast. Thank you.');
            } else {
                $this->deleteVote();
        //        $this->say('END Cancelled by user.');
            }

        });


    }

    public function deleteVote(){
        foreach ($this->elections as $election){
            $electionCollection = Election::find($election['id']);
            foreach ($electionCollection->elective_positions as $pstn){
                if ($pstn->vote) {
                    $pstn->vote->delete();
                }
            }
        }
        $this->startConversation();

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
            header('Content-type: text/plain');
            echo "END Thanks for your submission.";
            return true;
        }
        return false;
    }
}

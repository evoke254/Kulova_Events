<?php

namespace App\Bot;

use App\Models\Election;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Vote;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ussdVoting extends Conversation
{
    public $event; public $events;
    public Invite $voter;
    public $election; public $elections;
    public $positions;
    public $candidates;
    public $votes = [];
    public $SelectedElectionArr;


    public function __construct(Invite $voter)
    {
        $this->voter = $voter;

    }
    public function run(){
        $welcomeMessage = "CON  Welcome to Text-40 Digital Voting System. I'm here to assist you cast your vote. \n";
        $this->startConversation($welcomeMessage);
    }

    public function startConversation($welcomeMessage) {
//Display all events
        $this->events = Event::orderBy('start_date', 'Desc')
            ->get()->toArray();

        $opt = "";
        foreach($this->events as $key => $event) {
            $opt .= $key+1 . ": ". $event['name']. " \n ";
        }
        $qstn = $welcomeMessage. "Please select an event: \n ".   $opt ." 00 : Cancel ";

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
                $this->positions = $this->election->elective_positions->toArray();
                $this->selectElectivePositions();
            } else{
                $qstn = "CON  Invalid response. Please check and try again \n
                                : \n ".   $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }
        });

    }


    public function selectElectivePositions(){
        $countBallot = 0;
        $opt = "";
        foreach ($this->positions as $pstnKey => $pstn){
            if (  !empty($pstn['candidates']) && empty($this->voter->castVoteInPstn($pstn['id']) ) ) {

                $countBallot++;
                $opt .= Str::upper($pstn['position']). " \n ";
                $this->candidates = $pstn['candidates'];
                foreach ($this->candidates as $key => $candidate){

                    $prev_vote = $this->voter->castVote($pstn['id'], $candidate['id']);

                    if ( $prev_vote ){
                        $opt .= $key+1 . ": ".$candidate['name'] . " - ". $candidate['member_no'] ."**Elect  \n ";
                    }
                    else {
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

                    $prev_vote =  $this->voter->castVote($this->positions[$pstnKey]['id'], $this->candidates[$ans - 1]['id']);

                    if ($prev_vote){
                        $prev_vote->delete();
                    }

                    if ($this->voter) {
                        $castVote =  [
                            'elective_position_id' => $this->positions[$pstnKey]['id'],
                            'candidate_elective_position_id' => $this->candidates[$ans - 1]['id'],
                            'invite_id' => $this->voter->id,
                            'vote' => 1,
                        ];
                        $vote = Vote::create($castVote);
                        $this->positions[$pstnKey]['votes'] = $castVote;
                        array_push($this->votes, $vote);

                        $this->markBallot();

                    } else {

                        $this->say('END You are not eligible to vote');
                    }



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
//        dd('valid vote ;'. $validVotes .'cast :'. $myCastVotes);
        if ($myCastVotes != $validVotes){
            $this->selectElectivePositions();
        } else {

            $this->confirmBallot();
        }
    }

    public function confirmBallot(){

        $opt = "";
        foreach ($this->positions as $pstnKey => $pstn){

            if (!empty($pstn['candidates'])){

                $opt .= Str::upper($pstn['position']). " \n ";
                $this->candidates = $pstn['candidates'];
            }
            foreach ($this->candidates as $key => $candidate){

                if (isset($candidate['id'])) {

                    $prev_vote =  $this->voter->castVote($pstn['id'], $candidate['id']);

                }
                if ($prev_vote) {
                    $opt .= "- ".$candidate['name'] . " - ". $candidate['member_no'] ."**Elect  \n ";
                } else {
                    $opt .= "- ".$candidate['name'] . " - ". $candidate['member_no'] ."  \n ";
                }
            }
        }

        $qstn = "CON POSITIONS: \n ".   $opt ."\n 101 : Confirm\n 99 : Cancel and Start";
        $this->ask($qstn, function(Answer $answer) use ($opt, $pstnKey) {
            $ans = (int)$answer->getText();
            Log::info('$ans is : '.$ans);
            if ($ans == 101){
                $this->say('END Vote cast. Thank you.');
            } else {
                $this->deleteVote();
                //        $this->say('END Cancelled by user.');
            }

        });


    }

    public function deleteVote(){


        foreach ($this->positions as $pstnKey => $pstn) {

            if ((empty($pstn['votes']) && !empty($pstn['candidates']))) {
                $this->candidates = $pstn['candidates'];
                foreach ($this->candidates as $key => $candidate) {

                    $prev_vote =  $this->voter->castVote($pstn['id'], $candidate['id']);
                    if ($prev_vote){
                        $prev_vote->delete();
                    }
                }
            }
        }


        $this->startConversation('CON You squashed your previous ballot');

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

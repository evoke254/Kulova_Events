<?php

namespace App\Bot;

use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Vote;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class whatsappVoting extends Conversation
{
    public $event; public $events;
    public Invite $voter;
    public $election; public $elections;
    public $positions;
    public $candidates;
    public $votes = [];
    public $SelectedElectionArr;
    public $msgType;


    public function __construct(Invite $voter)
    {
        $this->voter = $voter;

    }
    public function run(){
        $welcomeMessage = "Welcome to Text-40 Digital Voting System. I'm here to assist you cast your vote.\n";
        $this->startConversation($welcomeMessage);
    }

    public function startConversation($welcomeMessage) {
//Display all events

//$this->bot->setInteractive(); TODO
        $this->events = Event::orderBy('start_date', 'Desc')
            ->get()->toArray();

        $opt = "";
        foreach($this->events as $key => $event) {
            $opt .= $key+1 . ": ". $event['name']. "\n";
        }
        $qstn = $welcomeMessage. "Please select an event: \n ". $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {

            $ans = (int)$answer->getText();

            if (isset($this->events[$ans - 1])){
                $this->event = Event::find($this->events[$ans - 1]['id']);
                $this->elections =  $this->event->elections->toArray();
                $this->selectElection();
            } else{
                $qstn = "Invalid response - _".$ans."_. Please check and try again\nEVENTS:\n". $opt ." 00 : Cancel ";
                $this->qstnFallback($qstn);
            }

        });
    }


    public function selectElection() {

        $opt = "";
        foreach($this->elections as $key => $election) {
            $opt .= $key+1 . ": ".$election['name']. "\n";
        }

        $qstn = "ELECTIONS:\n". $opt ." 00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {

            $ans = (int) $answer->getText() ;
            if (isset($this->elections[$ans - 1])){
                $this->election = Election::find($this->elections[$ans - 1]['id']);
                $this->SelectedElectionArr = $this->elections[$ans - 1];
                $this->positions = $this->election->elective_positions->toArray();
                $this->selectElectivePositions();
            } else{
                $qstn = "Invalid response - _".$ans."_. Please check and try again\n\n ". $opt ." 00 : Cancel ";
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
                        //Random check to c
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

            $qstn = "POSITIONS: \n ".   $opt ." 00 : Cancel ";
            $this->ask($qstn, function(Answer $answer) use ($opt, $pstnKey) {

                $ans = (int) $answer->getText() ;
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

                        $this->say('You are not eligible to vote');
                    }



                } else{
                    $qstn = " Invalid response - _".$ans."_. Please check and try again \n
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
        foreach ($this->votes as $vote){
            $postn = ElectivePosition::find($vote->elective_position_id);

            $opt .= Str::upper($postn->position). " \n ";
            $candidate = CandidateElectivePosition::find($vote->candidate_elective_position_id);

            $opt .= "- " . $candidate['name'] . " - " . $candidate['member_no'] . "**Elect  \n ";

        }

        $qstn = "POSITIONS: \n ".   $opt ."\n 1 : Confirm\n 2 : Cancel and Start";
        $this->ask($qstn, function(Answer $answer) use ($opt) {

            $ans = (int) $answer->getText() ;
            if ($ans == 1){
                $this->say('Vote cast. Thank you.');
            } else if ($ans == 2) {
                $this->votes = [];
                $this->deleteVote();
                $this->say('Cancelled by user. Dial *544# to try again');
            } else {

                $qstn = "Invalid Option ( ".$ans." ). Try again\nPOSITIONS:\n ". $opt ."\n 2 : Confirm\n 3 : Cancel and Start";
                $this->qstnFallback($qstn);
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
        $this->votes = [];

    }


    public function qstnFallback($qstn) {
        $this->repeat($qstn);
    }

    public function cancelConversation() {
        $this->votes = [];
        $this->say("Cancelled by user");
    }

    public function stopsConversation(IncomingMessage $message)
    {
        $ans = $message->getText();
        if ($ans == '00') {
            $this->cancelConversation();
        }
        return false;
    }
}

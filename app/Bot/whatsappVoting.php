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

class whatsappVoting extends Conversation
{
    public $event; public $events;
    public  $phoneNumber; public $userName;
    public  Invite $voter;
    public $election; public $elections;
    public $positions;
    public $candidates;
    public $votes = [];
    public $SelectedElectionArr;
    public $msgType;

    public $bot22;

    public function __construct( $phoneNumber, $userName, $voter = null)
    {
        $this->userName = $userName;
        $this->phoneNumber = $phoneNumber;
        $this->voter = $voter;
    }
    public function run(){

        $welcomeMessage = "Hello ".$this->userName.", \nwelcome to Text40 Digital Voting System. I'm here to assist you cast your vote.\n";
        if ($this->voter){
            $this->event = Event::find($this->voter->event_id);
            $this->elections =  $this->event->elections->toArray();
            $this->selectElection();
        } else {
            $this->startConversation($welcomeMessage);
        }
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
        $qstn = $welcomeMessage. "Please select an event: \n ". $opt ."00 : Cancel ";

        $this->ask($qstn, function(Answer $answer) use ($opt) {

            $ans = (int)$answer->getText();

            if (isset($this->events[$ans - 1])){
                $this->event = Event::find($this->events[$ans - 1]['id']);
                $this->elections =  $this->event->elections->toArray();

                //Check if user has been invited for election
                $no = substr($this->phoneNumber, -9);
                //Check if user has been invited to the Election
                $phoneNumbers = ["+254" . $no, "254" . $no, "0" . $no ];
                $voter = Invite::whereIn('phone_number', $phoneNumbers)
                    ->where('event_id', $this->event->id)
                    ->first();

                if ($voter){
                    $this->voter = $voter;
                    $this->selectElection();
                } else{
                    $qstn = "You have not been invited to this event/election. \n\nPlease select an event: \n ". $opt ."00 : Cancel" ;
                    $this->qstnFallback($qstn);
                }

            } else{
                $qstn = "Invalid response - _".$answer->getText()."_. Please check and try again\nEVENTS:\n". $opt ."00 : Cancel ";
                $this->qstnFallback($qstn);
            }

        });
    }


    public function selectElection() {

        $opt = "";
        foreach($this->elections as $key => $election) {
            $opt .= $key+1 . ": ".$election['name']. "\n";
        }
        if (empty($this->elections) ){
            $this->retryPrcs();
        } else {

            $qstn = "ELECTIONS:\n". $opt ."00 : Cancel ";
            $this->ask($qstn, function(Answer $answer) use ($opt) {

                $ans = (int) $answer->getText() ;
                if (isset($this->elections[$ans - 1])){
                    $this->election = Election::find($this->elections[$ans - 1]['id']);
                    $this->SelectedElectionArr = $this->elections[$ans - 1];
                    $this->positions = $this->election->elective_positions->toArray();
                    $this->selectElectivePositions();
                } else{
                    $qstn = "Invalid response - _".$answer->getText()."_. Please check and try again\n\n ". $opt ."00 : Cancel ";
                    $this->qstnFallback($qstn);
                }
            });
        }

    }


    public function selectElectivePositions(){
        $countBallot = 0;
        $countCdt = 0;
        $opt = "";


        foreach ($this->positions as $pstnKey => $pstn){

            if (  !empty($pstn['candidates']) ) {
                $countCdt++;
                if ($this->voter->castVoteInPstn($pstn['id'])){

                    $countBallot++;
                    $opt .= Str::upper($pstn['position']). " \n ";
                    $this->candidates = $pstn['candidates'];
                    foreach ($this->candidates as $key => $candidate){
                        $prev_votes = $this->voter->castVotes($pstn['id'], $candidate['id']);
                        if ( !$prev_votes->contains('candidate_elective_position_id', $candidate['id'])){
                            if ($this->election->type == 1){
//                                $opt .= $key+1 . ": ".$candidate['name'] . " - ". $candidate['member_no'] ." \n ";

                                $opt .= $key+1 . ": ".$candidate['name'] . " - ". $candidate['member_no'] ." \n ";
                            } else {
                                $opt .= $key+1 . ": ".$candidate['name']."\n ";
                            }
                        }
                    }
                    break;

                }
            }

        }

        if ($countBallot >0) {

            $qstn = Election::ELECTION_TYPE [$this->election->type]." : \n ".   $opt ."00 : Cancel ";
            $this->ask($qstn, function(Answer $answer) use ($opt, $pstnKey) {

                $ans = (int) $answer->getText() ;
                if (isset($this->positions[$pstnKey]) && isset($this->candidates[$ans - 1]['id']) ){

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
                    $qstn = "Invalid response - _".$answer->getText()."_. Please check and try again\n
                                : \n ".   $opt ." 00 : Cancel ";
                    $this->qstnFallback($qstn);
                }
            });


        }
        elseif ($countCdt == 0){
            $this->retryPrcs();

        } else {
            $this->confirmBallot();
        }

    }

    public function retryPrcs()
    {
        $qstn = "We are currently updating election details: \n99 : Retry";
        $this->ask($qstn, function(Answer $answer) {
            $ans = (int) $answer->getText();
            if ($ans == 99){
                $this->run();
            }
        });

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
        if(empty($this->votes)){
            $this->alreadyVoted();
        } else {
            $opt = "";
            foreach ($this->positions as $pstnKey => $pstn){
                $opt .= "*".$pstn['position']."*";
                $opt .= " \n ";
                $this->candidates = $pstn['candidates'];
                foreach ($this->candidates as $key => $candidate){

                    $prev_votes = $this->voter->castVotes($pstn['id'], $candidate['id']);
                    if ($this->election->type == 1){
                        if ($prev_votes->count() > 0) {
                            $opt .= "  • " . $candidate['name'] . " ✅  \n";
                        } else{
                            $opt .= "  • " . $candidate['name'] . " \n";
                        }
                    } else {
                        if ($prev_votes->count() > 0) {
                            $opt .= "  • ".$candidate['name'] . "✅\n";
                        } else {
                            $opt .= "  • ".$candidate['name'] . "\n";
                        }
                    }
                }

            }

            $qstn = "Cast Votes: \n ".   $opt ."\n1 : Confirm\n2 : Cancel and Start";
            $this->ask($qstn, function(Answer $answer) use ($opt) {

                $ans = (int) $answer->getText() ;
                if ($ans == 1){
                    $this->say('Vote cast. Thank you.');
                    $prov_rslts = $this->getProvisionalRslts();
                    $this->say($prov_rslts);

                } else if ($ans == 2) {
                    $this->votes = [];
                    $this->deleteVote();
                    $this->say('Cancelled by user. Text Vote to try again');
                } else {
                    $qstn = "Invalid Option ( ".$answer->getText()." ). Try again\n".$this->election->type.":\n ". $opt ."\n2 : Confirm\n3 : Cancel and Start";
                    $this->qstnFallback($qstn);
                }
            });

        }
    }

    public function deleteVote(){

        foreach ($this->positions as $pstnKey => $pstn) {

            if ((empty($pstn['votes']) && !empty($pstn['candidates']))) {
                $this->candidates = $pstn['candidates'];

                foreach ($this->candidates as $key => $candidate) {
                    $prev_vote =  $this->voter->castVotes($pstn['id'], $candidate['id']);
                    if ($prev_vote){
                        $prev_vote->delete();
                    }
                }
            }
        }
        $this->votes = [];

    }

    public function stopsConversation(IncomingMessage $message): bool
    {
        if ($message->getText() == '00') {
            if ($this->positions){
                $this->deleteVote();
            }
            return true;
        }

        return false;
    }

    public function alreadyVoted(){
        $prov_rslts = $this->getProvisionalRslts();
        $qstn = "You have already voted.\n \n". $prov_rslts." \n \n99 : HOME";

        $this->ask($qstn, function(Answer $answer) {
            $ans = (int) $answer->getText();
            if ($ans == 99){
                $this->run();
            }
        });
    }

    public function getProvisionalRslts()
    {
        $opt = "PROVISIONAL RSLTS \n";
        $opt .= " =========== \n";
        foreach ($this->positions as $pstnKey => $pstn){
            $opt .= "*".$pstn['position']."*";
            $opt .= " \n ";
            $this->candidates = $pstn['candidates'];
            $totalVotes = ElectivePosition::find($pstn['id'])->votes()->get()->count();
            foreach ($this->candidates as $key => $candidate){
                $candidateVotes = CandidateElectivePosition::find($candidate['id'])->votes()->get()->count();
                $rslts = round(($candidateVotes/ (($totalVotes > 0) ? $totalVotes : 1) * 100) , 1);
                if ($this->election->type == 1){
                    $opt .= "  • " . $candidate['name'] . " -   _". $rslts ."_ % \n";
                } else {
                    $opt .= "  • ".$candidate['name'] . " - _".$rslts."_ % \n";
                }
            }
        }

        return $opt;
    }


    public function qstnFallback($qstn) {
        $this->repeat($qstn);
    }


}

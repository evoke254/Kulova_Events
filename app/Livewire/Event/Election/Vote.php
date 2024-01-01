<?php

namespace App\Livewire\Event\Election;

use App\Models\ElectivePosition;
use App\Models\Invite;
use Livewire\Component;
use WireUi\Traits\Actions;

class Vote extends Component
{
    use Actions;
    public $election;

    public Invite $voter;
    public $ballot_papers = [];
    public $elective_positions;
    public $ballotCast = false;
    public function mount(){
        $this->elective_positions =  $this->election?->elective_positions;
    }


    public function castVote(ElectivePosition $pstn, $candidate){
        $prevcast = $this->countTrueFalseOccurrences($this->ballot_papers[$pstn->id]['candidate']);
        if ( $prevcast > $pstn->votes  ){
            unset($this->ballot_papers[$pstn->id]['candidate'][$candidate]);
            $this->notification()->error(
                $title = ' Error  ',
                $description = 'You have reached the maximum allowed votes for this position. Unselect a candidate to vote for another.'
            );
        }




    }

    public function countTrueFalseOccurrences(array $ballot): int {
        $result = 0;
        foreach ($ballot as $value) {
            if ($value === true || $value === 'true' || $value === 1 || $value === '1') {
                $result++;
            }
            /*elseif ($value === false || $value === 'false' || $value === 0 || $value === '0') {
                $result['false']++;
            }*/

        }

        return $result;
    }


    public function submit(){
        $this->ballotCast = true;
        foreach ($this->ballot_papers as $elective_position_id => $cast_vote){

            foreach ($cast_vote['candidate'] as $cdtId => $vt){
                if($vt){
                    $vote = new \App\Models\Vote();
                    $vote->elective_position_id = $elective_position_id;
                    $vote->invite_id = $this->voter->id;
                    $vote->candidate_elective_position_id = $cdtId;
                    $vote->save();
                }
            }
        }
        $this->notification()->success(
            $title = ' Vote Cast ',
            $description = 'Vote was successfully cast'
        );

    }
    public function render()
    {
        return view('livewire.event.election.vote');
    }
}

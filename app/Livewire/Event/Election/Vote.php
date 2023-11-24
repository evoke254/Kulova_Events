<?php

namespace App\Livewire\Event\Election;

use Livewire\Component;
use WireUi\Traits\Actions;

class Vote extends Component
{
    use Actions;
    public $election;
    public $ballot_papers = [];
    public $elective_positions;
    public function mount(){
        $this->elective_positions =  $this->election?->elective_positions;

    }

    public function submit(){

        foreach ($this->ballot_papers as $elective_position_id => $cast_vote){
            $vote = new \App\Models\Vote();
            $vote->elective_position_id = $elective_position_id;
            $vote->invite_id = 1;
            //TODO remember to add invite id. One member one vote validation
            $vote->candidate_elective_position_id = $cast_vote['candidate'];
            $vote->save();
        }

    }
    public function render()
    {
        return view('livewire.event.election.vote');
    }
}

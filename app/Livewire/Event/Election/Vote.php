<?php

namespace App\Livewire\Event\Election;

use Livewire\Component;

class Vote extends Component
{
    public $election;
    public $ballot_papers = [];
    public $elective_positions;
    public function mount(){
        $this->elective_positions =  $this->election?->elective_positions;

    }

    public function submit(){
        dd($this->ballot_papers);
    }
    public function render()
    {
        return view('livewire.event.election.vote');
    }
}

<?php

namespace App\Livewire\Event\Election;

use Livewire\Component;

class Show extends Component
{
    public $event;
    public $elections;
    public function mount(){
        //        $this->elections =
    }
    public function render()
    {
        return view('livewire.event.election.show');
    }
}

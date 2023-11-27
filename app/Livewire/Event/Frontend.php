<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Component;

class Frontend extends Component
{
    public $events;

    public function mount(){
        $this->events = Event::orderBy('start_date:', 'Desc')
                                                    ->get();
    }
    public function render()
    {
        return view('livewire.event.frontend');
    }
}
